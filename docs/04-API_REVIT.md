# 🔌 API REST para Integración con Revit - Versión 2.0

## 📋 Resumen Ejecutivo

Este documento describe la arquitectura y especificaciones de la **API REST** del sistema APU para conectarse con **Autodesk Revit** mediante **Python** y capturar información de modelos BIM.

---

## 🎯 Objetivos

1. **Exponer endpoints REST** desde el sistema APU
2. **Autenticación segura** con tokens JWT/OAuth2
3. **Capturar datos desde Revit** (elementos, cantidades, propiedades)
4. **Enviar datos al sistema APU** para cálculos y análisis
5. **Sincronización bidireccional** (Revit ↔ APU System)

---

## 🏗️ Arquitectura Propuesta

```
┌─────────────────────────────────────────────────────────────────┐
│                          REVIT (Autodesk)                        │
│  ┌───────────────────────────────────────────────────────────┐  │
│  │         Revit Python API (Python .NET - pythonnet)         │  │
│  │  - Acceso a objetos Revit (Walls, Floors, Families)       │  │
│  │  - Extracción de cantidades y propiedades                 │  │
│  └──────────────────────┬──────────────────────────────────────┘  │
└─────────────────────────┼──────────────────────────────────────┘
                           │ HTTP/REST
                           │ (JSON over HTTPS)
                           │ Token JWT
                           ▼
┌─────────────────────────────────────────────────────────────────┐
│                      APU SYSTEM (Symfony)                        │
│  ┌───────────────────────────────────────────────────────────┐  │
│  │                 API REST Endpoints                         │  │
│  │  POST   /api/v2/auth/login      (Autenticación)           │  │
│  │  POST   /api/v2/projects        (Crear proyecto desde BIM)│  │
│  │  GET    /api/v2/projects/{id}   (Consultar proyecto)      │  │
│  │  POST   /api/v2/elements        (Enviar elementos Revit)  │  │
│  │  GET    /api/v2/calculations    (Obtener cálculos APU)    │  │
│  │  POST   /api/v2/sync            (Sincronización completa) │  │
│  └───────────────────────────────────────────────────────────┘  │
│  ┌───────────────────────────────────────────────────────────┐  │
│  │             Security Layer (OWASP Compliant)              │  │
│  │  - JWT Token Authentication                                │  │
│  │  - Rate Limiting (100 req/min por token)                   │  │
│  │  - Input Validation & Sanitization                         │  │
│  │  - CORS configurado                                        │  │
│  │  - API Key + JWT (doble factor)                            │  │
│  └───────────────────────────────────────────────────────────┘  │
│  ┌───────────────────────────────────────────────────────────┐  │
│  │                   Database (MySQL)                         │  │
│  │  - projects (proyectos importados desde Revit)            │  │
│  │  - bim_elements (elementos del modelo)                    │  │
│  │  - apu_calculations (cálculos de APU)                     │  │
│  └───────────────────────────────────────────────────────────┘  │
└─────────────────────────────────────────────────────────────────┘
```

---

## 🔐 Seguridad y Autenticación

### 1. OAuth2 / JWT Tokens

**Flujo de autenticación:**

```
1. Cliente (Revit Plugin) → POST /api/v2/auth/login
   Headers:
     Content-Type: application/json
   Body:
     {
       "email": "usuario@empresa.com",
       "password": "password",
       "api_key": "API_KEY_GENERADA_EN_SISTEMA"
     }

2. Sistema APU valida credenciales + API Key

3. Sistema APU genera JWT Token:
   {
     "access_token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...",
     "token_type": "Bearer",
     "expires_in": 3600,
     "refresh_token": "refresh_token_here"
   }

4. Cliente usa token en todas las requests:
   Headers:
     Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...
     X-API-Key: API_KEY_GENERADA_EN_SISTEMA
```

### 2. API Keys

- Cada empresa (tenant) tiene una API Key única
- Se genera en el panel de Super Admin
- Se almacena hasheada en BD (Argon2ID)
- Rotación cada 90 días (configurable)

### 3. Rate Limiting

```yaml
# config/packages/api_rate_limiter.yaml
framework:
    rate_limiter:
        api_general:
            policy: 'sliding_window'
            limit: 100
            interval: '1 minute'

        api_imports:
            policy: 'fixed_window'
            limit: 10
            interval: '1 hour'
```

### 4. CORS Configuration

```yaml
# config/packages/nelmio_cors.yaml
nelmio_cors:
    defaults:
        origin_regex: true
        allow_origin: ['*'] # En producción: dominios específicos
        allow_methods: ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS']
        allow_headers: ['Content-Type', 'Authorization', 'X-API-Key']
        max_age: 3600
    paths:
        '^/api/':
            allow_origin: ['*']
            allow_headers: ['*']
            allow_methods: ['POST', 'GET', 'PUT', 'DELETE']
```

---

## 📡 Endpoints API v2

### 📌 1. Autenticación

#### POST `/api/v2/auth/login`

**Request:**

```json
{
    "email": "usuario@empresa.com",
    "password": "contraseña_segura",
    "api_key": "ak_1234567890abcdef"
}
```

**Response 200:**

```json
{
    "success": true,
    "data": {
        "access_token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...",
        "refresh_token": "refresh_token_here",
        "token_type": "Bearer",
        "expires_in": 3600,
        "user": {
            "id": 123,
            "email": "usuario@empresa.com",
            "tenant": "empresa-abc",
            "role": "admin"
        }
    }
}
```

**Response 401:**

```json
{
    "success": false,
    "error": {
        "code": "AUTH_FAILED",
        "message": "Credenciales inválidas"
    }
}
```

---

### 📌 2. Crear Proyecto desde Revit

#### POST `/api/v2/projects`

**Headers:**

```
Authorization: Bearer {token}
X-API-Key: {api_key}
Content-Type: application/json
```

**Request:**

```json
{
    "project_name": "Edificio Comercial XYZ",
    "revit_project_id": "12345-abcde-67890",
    "revit_project_name": "Edificio_Comercial.rvt",
    "location": "Quito, Ecuador",
    "description": "Edificio de 10 pisos con uso comercial",
    "metadata": {
        "revit_version": "2024",
        "author": "Arq. Juan Pérez",
        "created_date": "2026-03-17T10:30:00Z",
        "levels": 10,
        "total_area": 5000.0
    }
}
```

**Response 201:**

```json
{
    "success": true,
    "data": {
        "project_id": 456,
        "project_uuid": "uuid-project-456",
        "message": "Proyecto creado exitosamente",
        "sync_url": "/api/v2/projects/456/sync"
    }
}
```

---

### 📌 3. Enviar Elementos de Revit

#### POST `/api/v2/projects/{project_id}/elements`

**Request:**

```json
{
    "elements": [
        {
            "element_id": "1234567",
            "category": "Walls",
            "family": "Basic Wall",
            "type": "Generic - 200mm",
            "level": "Level 1",
            "properties": {
                "length": 10.5,
                "height": 3.0,
                "area": 31.5,
                "volume": 6.3,
                "material": "Concrete"
            },
            "parameters": {
                "Mark": "W-101",
                "Fire Rating": "2 Hours",
                "Comments": "Muro estructural"
            },
            "location": {
                "x": 1000.0,
                "y": 2000.0,
                "z": 0.0
            }
        },
        {
            "element_id": "1234568",
            "category": "Floors",
            "family": "Floor",
            "type": "Generic - 150mm",
            "level": "Level 1",
            "properties": {
                "area": 250.0,
                "volume": 37.5,
                "perimeter": 65.0
            }
        }
    ]
}
```

**Response 201:**

```json
{
    "success": true,
    "data": {
        "elements_imported": 2,
        "elements_updated": 0,
        "elements_failed": 0,
        "calculation_status": "pending",
        "message": "Elementos importados. Cálculos en proceso."
    }
}
```

---

### 📌 4. Obtener Cálculos de APU

#### GET `/api/v2/projects/{project_id}/calculations`

**Query Parameters:**

```
?category=Walls
&status=completed
&page=1
&per_page=50
```

**Response 200:**

```json
{
    "success": true,
    "data": {
        "project_id": 456,
        "total_calculations": 120,
        "calculations": [
            {
                "id": 789,
                "element_id": "1234567",
                "category": "Walls",
                "description": "Muro de hormigón 20cm",
                "quantity": 31.5,
                "unit": "m²",
                "unit_cost": 45.5,
                "total_cost": 1433.25,
                "breakdown": {
                    "materials": 850.0,
                    "labor": 450.0,
                    "equipment": 133.25
                },
                "calculated_at": "2026-03-17T11:00:00Z"
            }
        ],
        "summary": {
            "total_cost": 125000.5,
            "materials_cost": 75000.0,
            "labor_cost": 35000.0,
            "equipment_cost": 15000.5
        },
        "pagination": {
            "current_page": 1,
            "per_page": 50,
            "total_pages": 3,
            "total_items": 120
        }
    }
}
```

---

### 📌 5. Sincronización Completa

#### POST `/api/v2/projects/{project_id}/sync`

**Request:**

```json
{
    "sync_type": "full", // "full" | "incremental"
    "options": {
        "update_existing": true,
        "delete_removed": false,
        "recalculate_all": true
    }
}
```

**Response 202 (Accepted - Async):**

```json
{
    "success": true,
    "data": {
        "sync_job_id": "sync-123456",
        "status": "processing",
        "started_at": "2026-03-17T12:00:00Z",
        "estimated_time": "5 minutes",
        "status_url": "/api/v2/sync/status/sync-123456"
    }
}
```

---

## 🐍 Cliente Python para Revit

### Instalación de Dependencias

```bash
# En el entorno de Revit (IronPython o Python .NET)
pip install requests
pip install pythonnet  # Para acceso a Revit API
pip install python-dotenv
```

### Código Ejemplo: Autenticación

```python
# revit_apu_connector.py
import requests
import json
from typing import Dict, List, Any

class APUSystemClient:
    """Cliente para conectar Revit con APU System"""

    def __init__(self, base_url: str, api_key: str):
        self.base_url = base_url.rstrip('/')
        self.api_key = api_key
        self.access_token = None
        self.headers = {
            'Content-Type': 'application/json',
            'X-API-Key': self.api_key
        }

    def login(self, email: str, password: str) -> bool:
        """Autenticarse en el sistema APU"""
        url = f"{self.base_url}/api/v2/auth/login"

        payload = {
            'email': email,
            'password': password,
            'api_key': self.api_key
        }

        try:
            response = requests.post(url, json=payload, headers=self.headers)
            response.raise_for_status()

            data = response.json()
            if data['success']:
                self.access_token = data['data']['access_token']
                self.headers['Authorization'] = f"Bearer {self.access_token}"
                print("✅ Autenticación exitosa")
                return True
            else:
                print(f"❌ Error: {data['error']['message']}")
                return False

        except requests.exceptions.RequestException as e:
            print(f"❌ Error de conexión: {e}")
            return False

    def create_project(self, project_data: Dict[str, Any]) -> Dict:
        """Crear proyecto en APU System desde Revit"""
        url = f"{self.base_url}/api/v2/projects"

        try:
            response = requests.post(url, json=project_data, headers=self.headers)
            response.raise_for_status()
            return response.json()
        except requests.exceptions.RequestException as e:
            print(f"❌ Error al crear proyecto: {e}")
            return {'success': False, 'error': str(e)}

    def send_elements(self, project_id: int, elements: List[Dict]) -> Dict:
        """Enviar elementos de Revit al sistema APU"""
        url = f"{self.base_url}/api/v2/projects/{project_id}/elements"

        payload = {'elements': elements}

        try:
            response = requests.post(url, json=payload, headers=self.headers)
            response.raise_for_status()
            return response.json()
        except requests.exceptions.RequestException as e:
            print(f"❌ Error al enviar elementos: {e}")
            return {'success': False, 'error': str(e)}

    def get_calculations(self, project_id: int, category: str = None) -> Dict:
        """Obtener cálculos de APU del sistema"""
        url = f"{self.base_url}/api/v2/projects/{project_id}/calculations"

        params = {}
        if category:
            params['category'] = category

        try:
            response = requests.get(url, params=params, headers=self.headers)
            response.raise_for_status()
            return response.json()
        except requests.exceptions.RequestException as e:
            print(f"❌ Error al obtener cálculos: {e}")
            return {'success': False, 'error': str(e)}


# ═══════════════════════════════════════════════════
# EJEMPLO DE USO
# ═══════════════════════════════════════════════════

if __name__ == "__main__":
    # Configuración
    BASE_URL = "https://apu-system.empresa.com"
    API_KEY = "ak_1234567890abcdef"
    EMAIL = "usuario@empresa.com"
    PASSWORD = "contraseña_segura"

    # Crear cliente
    client = APUSystemClient(BASE_URL, API_KEY)

    # 1. Autenticar
    if not client.login(EMAIL, PASSWORD):
        exit(1)

    # 2. Crear proyecto
    project_data = {
        'project_name': 'Edificio Comercial XYZ',
        'revit_project_id': '12345-abcde',
        'revit_project_name': 'Edificio.rvt',
        'location': 'Quito, Ecuador',
        'metadata': {
            'revit_version': '2024',
            'levels': 10,
            'total_area': 5000.0
        }
    }

    result = client.create_project(project_data)
    if result['success']:
        project_id = result['data']['project_id']
        print(f"✅ Proyecto creado: ID {project_id}")
    else:
        print("❌ Error al crear proyecto")
        exit(1)

    # 3. Enviar elementos (simulado)
    elements = [
        {
            'element_id': '1234567',
            'category': 'Walls',
            'family': 'Basic Wall',
            'type': 'Generic - 200mm',
            'level': 'Level 1',
            'properties': {
                'length': 10.5,
                'height': 3.0,
                'area': 31.5,
                'volume': 6.3
            }
        }
    ]

    result = client.send_elements(project_id, elements)
    if result['success']:
        print(f"✅ {result['data']['elements_imported']} elementos importados")

    # 4. Obtener cálculos
    result = client.get_calculations(project_id, category='Walls')
    if result['success']:
        total = result['data']['summary']['total_cost']
        print(f"✅ Costo total de muros: ${total:,.2f}")
```

---

### Código Ejemplo: Extraer Datos de Revit

```python
# revit_data_extractor.py
import clr

# Referencias a Revit API
clr.AddReference('RevitAPI')
clr.AddReference('RevitAPIUI')

from Autodesk.Revit.DB import *
from Autodesk.Revit.UI import *

class RevitDataExtractor:
    """Extractor de datos de Revit para enviar a APU System"""

    def __init__(self, doc: Document):
        self.doc = doc

    def get_project_info(self) -> dict:
        """Obtener información general del proyecto Revit"""
        project_info = self.doc.ProjectInformation

        return {
            'project_name': project_info.Name,
            'revit_project_id': self.doc.ProjectInformation.UniqueId,
            'revit_project_name': self.doc.Title,
            'location': project_info.Address if hasattr(project_info, 'Address') else '',
            'metadata': {
                'revit_version': self.doc.Application.VersionNumber,
                'author': project_info.Author,
                'created_date': str(project_info.IssueDate) if hasattr(project_info, 'IssueDate') else ''
            }
        }

    def extract_walls(self) -> list:
        """Extraer todos los muros del modelo"""
        collector = FilteredElementCollector(self.doc)
        walls = collector.OfClass(Wall).ToElements()

        elements = []
        for wall in walls:
            try:
                # Obtener parámetros
                mark = wall.get_Parameter(BuiltInParameter.ALL_MODEL_MARK)
                level = self.doc.GetElement(wall.LevelId)

                # Obtener geometría
                location = wall.Location
                if isinstance(location, LocationCurve):
                    curve = location.Curve
                    length = curve.Length  # En pies, convertir a metros
                    length_m = length * 0.3048

                # Calcular área
                area_param = wall.get_Parameter(BuiltInParameter.HOST_AREA_COMPUTED)
                area = area_param.AsDouble() if area_param else 0
                area_m2 = area * 0.09290304  # Convertir de ft² a m²

                # Calcular volumen
                volume_param = wall.get_Parameter(BuiltInParameter.HOST_VOLUME_COMPUTED)
                volume = volume_param.AsDouble() if volume_param else 0
                volume_m3 = volume * 0.0283168  # Convertir de ft³ a m³

                element_data = {
                    'element_id': wall.UniqueId,
                    'category': 'Walls',
                    'family': wall.WallType.FamilyName,
                    'type': wall.WallType.Name,
                    'level': level.Name if level else 'Unknown',
                    'properties': {
                        'length': round(length_m, 2),
                        'height': round(wall.WallType.Width * 0.3048, 2),
                        'area': round(area_m2, 2),
                        'volume': round(volume_m3, 2)
                    },
                    'parameters': {
                        'Mark': mark.AsString() if mark else '',
                        'Fire_Rating': self._get_parameter_value(wall, 'Fire Rating'),
                        'Comments': self._get_parameter_value(wall, 'Comments')
                    }
                }

                elements.append(element_data)

            except Exception as e:
                print(f"Error procesando muro {wall.Id}: {e}")
                continue

        return elements

    def extract_floors(self) -> list:
        """Extraer todas las losas del modelo"""
        collector = FilteredElementCollector(self.doc)
        floors = collector.OfClass(Floor).ToElements()

        elements = []
        for floor in floors:
            try:
                level = self.doc.GetElement(floor.LevelId)

                # Área
                area_param = floor.get_Parameter(BuiltInParameter.HOST_AREA_COMPUTED)
                area = area_param.AsDouble() if area_param else 0
                area_m2 = area * 0.09290304

                # Volumen
                volume_param = floor.get_Parameter(BuiltInParameter.HOST_VOLUME_COMPUTED)
                volume = volume_param.AsDouble() if volume_param else 0
                volume_m3 = volume * 0.0283168

                # Perímetro
                perimeter_param = floor.get_Parameter(BuiltInParameter.FLOOR_ATTR_PERIMETER  _LENGTH)
                perimeter = perimeter_param.AsDouble() if perimeter_param else 0
                perimeter_m = perimeter * 0.3048

                element_data = {
                    'element_id': floor.UniqueId,
                    'category': 'Floors',
                    'family': floor.FloorType.FamilyName,
                    'type': floor.FloorType.Name,
                    'level': level.Name if level else 'Unknown',
                    'properties': {
                        'area': round(area_m2, 2),
                        'volume': round(volume_m3, 2),
                        'perimeter': round(perimeter_m, 2)
                    }
                }

                elements.append(element_data)

            except Exception as e:
                print(f"Error procesando losa {floor.Id}: {e}")
                continue

        return elements

    def _get_parameter_value(self, element: Element, param_name: str) -> str:
        """Obtener valor de parámetro por nombre"""
        try:
            param = element.LookupParameter(param_name)
            if param:
                if param.StorageType == StorageType.String:
                    return param.AsString() or ''
                elif param.StorageType == StorageType.Integer:
                    return str(param.AsInteger())
                elif param.StorageType == StorageType.Double:
                    return str(round(param.AsDouble(), 2))
            return ''
        except:
            return ''


# ═══════════════════════════════════════════════════
# EJEMPLO DE USO EN REVIT
# ═══════════════════════════════════════════════════

def main(doc: Document):
    """Función principal para ejecutar desde Revit"""

    # 1. Extraer datos de Revit
    extractor = RevitDataExtractor(doc)

    print("Extrayendo datos del proyecto...")
    project_info = extractor.get_project_info()

    print("Extrayendo muros...")
    walls = extractor.extract_walls()

    print("Extrayendo losas...")
    floors = extractor.extract_floors()

    all_elements = walls + floors
    print(f"Total elementos extraídos: {len(all_elements)}")

    # 2. Conectar con APU System
    client = APUSystemClient(
        base_url="https://apu-system.empresa.com",
        api_key="ak_1234567890abcdef"
    )

    if not client.login("usuario@empresa.com", "password"):
        TaskDialog.Show("Error", "No se pudo autenticar con APU System")
        return

    # 3. Crear proyecto
    result = client.create_project(project_info)
    if not result['success']:
        TaskDialog.Show("Error", "No se pudo crear el proyecto")
        return

    project_id = result['data']['project_id']

    # 4. Enviar elementos
    result = client.send_elements(project_id, all_elements)
    if result['success']:
        imported = result['data']['elements_imported']
        TaskDialog.Show(
            "Éxito",
            f"Proyecto sincronizado:\n{imported} elementos importados"
        )
    else:
        TaskDialog.Show("Error", "Error al enviar elementos")


# Ejecutar desde Revit
if __name__ == "__main__":
    doc = __revit__.ActiveUIDocument.Document
    main(doc)
```

---

## 🛡️ Consideraciones de Seguridad OWASP 2026

### ✅ Implementado

1. **A01: Broken Access Control**
    - JWT + API Key (doble autenticación)
    - Verificación de tenant en cada request
    - Roles: USER, ADMIN, API_USER

2. **A02: Cryptographic Failures**
    - HTTPS obligatorio en producción
    - JWT firmado con HS256
    - API Keys hasheadas (Argon2ID)

3. **A03: Injection**
    - Doctrine ORM (protección SQL injection)
    - Validación de JSON schemas
    - Sanitización de inputs

4. **A04: Insecure Design**
    - Rate limiting: 100 req/min
    - Timeout de tokens: 1 hora
    - Logs de todas las operaciones API

5. **A05: Security Misconfiguration**
    - Headers de seguridad (CSP, HSTS, etc.)
    - CORS configurado
    - Error handling sin info sensible

6. **A09: Security Logging**
    - Log de login, requests, errores
    - Monitoreo de uso de API
    - Alertas por uso anómalo

---

## 📊 Modelo de Datos

### Tabla: `api_keys`

```sql
CREATE TABLE api_keys (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tenant_id BIGINT UNSIGNED NOT NULL,
    key_hash VARCHAR(255) NOT NULL,
    key_prefix VARCHAR(10) NOT NULL,
    name VARCHAR(100) NOT NULL,
    last_used_at TIMESTAMP NULL,
    expires_at TIMESTAMP NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (tenant_id) REFERENCES tenants(id) ON DELETE CASCADE,
    INDEX idx_key_prefix (key_prefix),
    INDEX idx_tenant (tenant_id)
);
```

### Tabla: `bim_projects`

```sql
CREATE TABLE bim_projects (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tenant_id BIGINT UNSIGNED NOT NULL,
    uuid VARCHAR(36) UNIQUE NOT NULL,
    project_name VARCHAR(255) NOT NULL,
    revit_project_id VARCHAR(255),
    revit_project_name VARCHAR(255),
    location VARCHAR(255),
    description TEXT,
    metadata JSON,
    sync_status ENUM('pending', 'syncing', 'completed', 'failed') DEFAULT 'pending',
    last_sync_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (tenant_id) REFERENCES tenants(id) ON DELETE CASCADE
);
```

### Tabla: `bim_elements`

```sql
CREATE TABLE bim_elements (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    project_id BIGINT UNSIGNED NOT NULL,
    element_id VARCHAR(255) NOT NULL,
    category VARCHAR(50),
    family VARCHAR(100),
    type VARCHAR(100),
    level VARCHAR(50),
    properties JSON,
    parameters JSON,
    location JSON,
    quantity DECIMAL(15, 4),
    unit VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (project_id) REFERENCES bim_projects(id) ON DELETE CASCADE,
    UNIQUE KEY unique_element (project_id, element_id),
    INDEX idx_category (category),
    INDEX idx_level (level)
);
```

### Tabla: `apu_calculations`

```sql
CREATE TABLE apu_calculations (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    element_id BIGINT UNSIGNED NOT NULL,
    description VARCHAR(255),
    quantity DECIMAL(15, 4),
    unit VARCHAR(20),
    unit_cost DECIMAL(15, 2),
    total_cost DECIMAL(15, 2),
    breakdown JSON,  -- {"materials": 100, "labor": 50, "equipment": 25}
    status ENUM('pending', 'calculated', 'approved') DEFAULT 'pending',
    calculated_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (element_id) REFERENCES bim_elements(id) ON DELETE CASCADE,
    INDEX idx_status (status)
);
```

---

## 🚀 Roadmap de Implementación

### Fase 1 (Sprint 1-2): Infraestructura API

- ✅ Configurar Symfony APIRest Bundle
- ✅ Implementar autenticación JWT
- ✅ Crear sistema de API Keys
- ✅ Configurar Rate Limiting
- ✅ Implementar CORS
- ✅ Security headers

### Fase 2 (Sprint 3-4): Endpoints Core

- ⏳ POST /auth/login
- ⏳ POST /projects
- ⏳ POST /projects/{id}/elements
- ⏳ GET /projects/{id}/calculations
- ⏳ Validación de schemas JSON

### Fase 3 (Sprint 5-6): Cliente Python

- ⏳ APUSystemClient class
- ⏳ RevitDataExtractor class
- ⏳ Manejo de errores robusto
- ⏳ Tests unitarios
- ⏳ Documentación Python

### Fase 4 (Sprint 7-8): Revit Plugin

- ⏳ IU en Revit (Ribbon Tab)
- ⏳ Configuración de conexión
- ⏳ Extracción automática de elementos
- ⏳ Sincronización bidireccional
- ⏳ Manejo de cambios incrementales

### Fase 5 (Sprint 9-10): Testing & Deployment

- ⏳ Tests de integración
- ⏳ Tests de carga (1000 elementos)
- ⏳ Documentación completa
- ⏳ Deploy a producción
- ⏳ Capacitación usuarios

---

## 📚 Referencias

- [Autodesk Revit API Documentation](https://www.revitapidocs.com/)
- [Python.NET Documentation](https://pythonnet.github.io/)
- [Symfony API Platform](https://api-platform.com/)
- [JWT Best Practices](https://tools.ietf.org/html/rfc8725)
- [OWASP API Security Top 10](https://owasp.org/www-project-api-security/)

---

## 📞 Soporte Técnico

Para dudas sobre la implementación de la API:

- **Documentación**: `/docs/API_REST_REVIT.md` (este archivo)
- **Swagger UI**: `https://apu-system.empresa.com/api/docs`
- **Email**: api-support@empresa.com

---

**Versión**: 2.0
**Fecha**: 17 de marzo de 2026
**Autor**: Equipo de Desarrollo APU System
