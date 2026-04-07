<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* apu/create.html.twig */
class __TwigTemplate_b9b229c4f6872b43646f97b7ac7c5c96 extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'body' => [$this, 'block_body'],
        ];
    }

    protected function doGetParent(array $context): bool|string|Template|TemplateWrapper
    {
        // line 1
        return "base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "apu/create.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "apu/create.html.twig"));

        $this->parent = $this->load("base.html.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

    }

    // line 3
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "title"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "title"));

        yield "Crear APU";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

        yield from [];
    }

    // line 5
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_body(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        // line 6
        yield "<div class=\"container mt-4\">
    <h1><i class=\"bi bi-calculator\"></i> Nuevo Análisis de Precios Unitarios</h1>

    <form method=\"POST\" id=\"apuForm\">
        <div class=\"card mb-3\">
            <div class=\"card-header bg-primary text-white\">
                Datos Principales
            </div>
            <div class=\"card-body\">
                <div class=\"row\">
                    <div class=\"col-md-8\">
                        <div class=\"mb-3\">
                            <label class=\"form-label\">Descripción del Rubro</label>
                            <input type=\"text\" class=\"form-control\" name=\"description\"
                                   placeholder=\"Ej: Provisión e instalación de porcelanato...\" required>
                        </div>
                    </div>
                    <div class=\"col-md-4\">
                        <div class=\"mb-3\">
                            <label class=\"form-label\">Unidad</label>
                            <select class=\"form-select\" name=\"unit\" required>
                                <option value=\"\">Seleccionar...</option>
                                <option value=\"m²\">m²</option>
                                <option value=\"m³\">m³</option>
                                <option value=\"m\">m (metro lineal)</option>
                                <option value=\"kg\">kg</option>
                                <option value=\"u\">u (unidad)</option>
                                <option value=\"GLB\">GLB (global)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class=\"row\">
                    <div class=\"col-md-6\">
                        <div class=\"mb-3\">
                            <label class=\"form-label\">K(H/U)</label>
                            <input type=\"number\" step=\"0.0001\" class=\"form-control\" name=\"khu\" required>
                        </div>
                    </div>
                    <div class=\"col-md-6\">
                        <div class=\"mb-3\">
                            <label class=\"form-label\">Rend. u/h</label>
                            <input type=\"number\" step=\"0.0001\" class=\"form-control\" name=\"rendimiento_uh\" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección EQUIPO -->
        <div class=\"card mb-3\">
            <div class=\"card-header bg-warning\">
                <i class=\"bi bi-tools\"></i> Equipo
                <button type=\"button\" class=\"btn btn-sm btn-light float-end\" onclick=\"addEquipmentRow()\">
                    <i class=\"bi bi-plus\"></i> Agregar
                </button>
            </div>
            <div class=\"card-body\">
                <table class=\"table table-sm\" id=\"equipmentTable\">
                    <thead>
                        <tr>
                            <th style=\"width: 40%\">Descripción</th>
                            <th style=\"width: 10%\">Número</th>
                            <th style=\"width: 20%\">Tarifa</th>
                            <th style=\"width: 20%\">C/HORA</th>
                            <th style=\"width: 10%\">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Filas dinámicas -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Sección MANO DE OBRA -->
        <div class=\"card mb-3\">
            <div class=\"card-header bg-info text-white\">
                <i class=\"bi bi-people\"></i> Mano de Obra
                <button type=\"button\" class=\"btn btn-sm btn-light float-end\" onclick=\"addLaborRow()\">
                    <i class=\"bi bi-plus\"></i> Agregar
                </button>
            </div>
            <div class=\"card-body\">
                <table class=\"table table-sm\" id=\"laborTable\">
                    <thead>
                        <tr>
                            <th style=\"width: 40%\">Descripción</th>
                            <th style=\"width: 10%\">Número</th>
                            <th style=\"width: 20%\">JOR./HORA</th>
                            <th style=\"width: 20%\">C/HORA</th>
                            <th style=\"width: 10%\">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Filas dinámicas -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Sección MATERIALES -->
        <div class=\"card mb-3\">
            <div class=\"card-header bg-success text-white\">
                <i class=\"bi bi-box-seam\"></i> Materiales
                <button type=\"button\" class=\"btn btn-sm btn-light float-end\" onclick=\"addMaterialRow()\">
                    <i class=\"bi bi-plus\"></i> Agregar
                </button>
            </div>
            <div class=\"card-body\">
                <table class=\"table table-sm\" id=\"materialTable\">
                    <thead>
                        <tr>
                            <th style=\"width: 40%\">Descripción</th>
                            <th style=\"width: 15%\">Unidad</th>
                            <th style=\"width: 20%\">Cantidad</th>
                            <th style=\"width: 15%\">Precio Unit.</th>
                            <th style=\"width: 10%\">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Filas dinámicas -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Sección TRANSPORTE -->
        <div class=\"card mb-3\">
            <div class=\"card-header bg-secondary text-white\">
                <i class=\"bi bi-truck\"></i> Transporte
                <button type=\"button\" class=\"btn btn-sm btn-light float-end\" onclick=\"addTransportRow()\">
                    <i class=\"bi bi-plus\"></i> Agregar
                </button>
            </div>
            <div class=\"card-body\">
                <table class=\"table table-sm\" id=\"transportTable\">
                    <thead>
                        <tr>
                            <th style=\"width: 30%\">Descripción</th>
                            <th style=\"width: 15%\">Unidad</th>
                            <th style=\"width: 15%\">Cantidad</th>
                            <th style=\"width: 15%\">DMT (km)</th>
                            <th style=\"width: 15%\">Tarifa/km</th>
                            <th style=\"width: 10%\">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Filas dinámicas -->
                    </tbody>
                </table>
            </div>
        </div>

        <div class=\"text-end\">
            <button type=\"button\" class=\"btn btn-outline-secondary\" onclick=\"history.back()\">Cancelar</button>
            <button type=\"submit\" class=\"btn btn-primary\">
                <i class=\"bi bi-save\"></i> Guardar APU
            </button>
        </div>
    </form>
</div>

<script>
let equipmentIndex = 0;
let laborIndex = 0;
let materialIndex = 0;
let transportIndex = 0;

function addEquipmentRow() {
    const tbody = document.querySelector('#equipmentTable tbody');
    const row = document.createElement('tr');
    row.innerHTML = `
        <td><input type=\"text\" class=\"form-control form-control-sm\" name=\"equipment[\${equipmentIndex}][descripcion]\" required></td>
        <td><input type=\"number\" class=\"form-control form-control-sm\" name=\"equipment[\${equipmentIndex}][numero]\" required></td>
        <td><input type=\"number\" step=\"0.01\" class=\"form-control form-control-sm\" name=\"equipment[\${equipmentIndex}][tarifa]\" required></td>
        <td><input type=\"number\" step=\"0.0001\" class=\"form-control form-control-sm\" name=\"equipment[\${equipmentIndex}][c_hora]\" required></td>
        <td><button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"this.closest('tr').remove()\"><i class=\"bi bi-trash\"></i></button></td>
    `;
    tbody.appendChild(row);
    equipmentIndex++;
}

function addLaborRow() {
    const tbody = document.querySelector('#laborTable tbody');
    const row = document.createElement('tr');
    row.innerHTML = `
        <td><input type=\"text\" class=\"form-control form-control-sm\" name=\"labor[\${laborIndex}][descripcion]\" required></td>
        <td><input type=\"number\" class=\"form-control form-control-sm\" name=\"labor[\${laborIndex}][numero]\" required></td>
        <td><input type=\"number\" step=\"0.0001\" class=\"form-control form-control-sm\" name=\"labor[\${laborIndex}][jor_hora]\" required></td>
        <td><input type=\"number\" step=\"0.01\" class=\"form-control form-control-sm\" name=\"labor[\${laborIndex}][c_hora]\" required></td>
        <td><button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"this.closest('tr').remove()\"><i class=\"bi bi-trash\"></i></button></td>
    `;
    tbody.appendChild(row);
    laborIndex++;
}

function addMaterialRow() {
    const tbody = document.querySelector('#materialTable tbody');
    const row = document.createElement('tr');
    row.innerHTML = `
        <td><input type=\"text\" class=\"form-control form-control-sm\" name=\"materials[\${materialIndex}][descripcion]\" required></td>
        <td><input type=\"text\" class=\"form-control form-control-sm\" name=\"materials[\${materialIndex}][unidad]\" required></td>
        <td><input type=\"number\" step=\"0.0001\" class=\"form-control form-control-sm\" name=\"materials[\${materialIndex}][cantidad]\" required></td>
        <td><input type=\"number\" step=\"0.01\" class=\"form-control form-control-sm\" name=\"materials[\${materialIndex}][precio_unitario]\" required></td>
        <td><button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"this.closest('tr').remove()\"><i class=\"bi bi-trash\"></i></button></td>
    `;
    tbody.appendChild(row);
    materialIndex++;
}

function addTransportRow() {
    const tbody = document.querySelector('#transportTable tbody');
    const row = document.createElement('tr');
    row.innerHTML = `
        <td><input type=\"text\" class=\"form-control form-control-sm\" name=\"transport[\${transportIndex}][descripcion]\" required></td>
        <td><input type=\"text\" class=\"form-control form-control-sm\" name=\"transport[\${transportIndex}][unidad]\" required></td>
        <td><input type=\"number\" step=\"0.0001\" class=\"form-control form-control-sm\" name=\"transport[\${transportIndex}][cantidad]\" required></td>
        <td><input type=\"number\" step=\"0.01\" class=\"form-control form-control-sm\" name=\"transport[\${transportIndex}][dmt]\" required></td>
        <td><input type=\"number\" step=\"0.01\" class=\"form-control form-control-sm\" name=\"transport[\${transportIndex}][tarifa_km]\" required></td>
        <td><button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"this.closest('tr').remove()\"><i class=\"bi bi-trash\"></i></button></td>
    `;
    tbody.appendChild(row);
    transportIndex++;
}

// Agregar al menos una fila inicial en cada sección
addEquipmentRow();
addLaborRow();
addMaterialRow();
addTransportRow();
</script>
";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "apu/create.html.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  100 => 6,  87 => 5,  64 => 3,  41 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("{% extends 'base.html.twig' %}

{% block title %}Crear APU{% endblock %}

{% block body %}
<div class=\"container mt-4\">
    <h1><i class=\"bi bi-calculator\"></i> Nuevo Análisis de Precios Unitarios</h1>

    <form method=\"POST\" id=\"apuForm\">
        <div class=\"card mb-3\">
            <div class=\"card-header bg-primary text-white\">
                Datos Principales
            </div>
            <div class=\"card-body\">
                <div class=\"row\">
                    <div class=\"col-md-8\">
                        <div class=\"mb-3\">
                            <label class=\"form-label\">Descripción del Rubro</label>
                            <input type=\"text\" class=\"form-control\" name=\"description\"
                                   placeholder=\"Ej: Provisión e instalación de porcelanato...\" required>
                        </div>
                    </div>
                    <div class=\"col-md-4\">
                        <div class=\"mb-3\">
                            <label class=\"form-label\">Unidad</label>
                            <select class=\"form-select\" name=\"unit\" required>
                                <option value=\"\">Seleccionar...</option>
                                <option value=\"m²\">m²</option>
                                <option value=\"m³\">m³</option>
                                <option value=\"m\">m (metro lineal)</option>
                                <option value=\"kg\">kg</option>
                                <option value=\"u\">u (unidad)</option>
                                <option value=\"GLB\">GLB (global)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class=\"row\">
                    <div class=\"col-md-6\">
                        <div class=\"mb-3\">
                            <label class=\"form-label\">K(H/U)</label>
                            <input type=\"number\" step=\"0.0001\" class=\"form-control\" name=\"khu\" required>
                        </div>
                    </div>
                    <div class=\"col-md-6\">
                        <div class=\"mb-3\">
                            <label class=\"form-label\">Rend. u/h</label>
                            <input type=\"number\" step=\"0.0001\" class=\"form-control\" name=\"rendimiento_uh\" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección EQUIPO -->
        <div class=\"card mb-3\">
            <div class=\"card-header bg-warning\">
                <i class=\"bi bi-tools\"></i> Equipo
                <button type=\"button\" class=\"btn btn-sm btn-light float-end\" onclick=\"addEquipmentRow()\">
                    <i class=\"bi bi-plus\"></i> Agregar
                </button>
            </div>
            <div class=\"card-body\">
                <table class=\"table table-sm\" id=\"equipmentTable\">
                    <thead>
                        <tr>
                            <th style=\"width: 40%\">Descripción</th>
                            <th style=\"width: 10%\">Número</th>
                            <th style=\"width: 20%\">Tarifa</th>
                            <th style=\"width: 20%\">C/HORA</th>
                            <th style=\"width: 10%\">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Filas dinámicas -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Sección MANO DE OBRA -->
        <div class=\"card mb-3\">
            <div class=\"card-header bg-info text-white\">
                <i class=\"bi bi-people\"></i> Mano de Obra
                <button type=\"button\" class=\"btn btn-sm btn-light float-end\" onclick=\"addLaborRow()\">
                    <i class=\"bi bi-plus\"></i> Agregar
                </button>
            </div>
            <div class=\"card-body\">
                <table class=\"table table-sm\" id=\"laborTable\">
                    <thead>
                        <tr>
                            <th style=\"width: 40%\">Descripción</th>
                            <th style=\"width: 10%\">Número</th>
                            <th style=\"width: 20%\">JOR./HORA</th>
                            <th style=\"width: 20%\">C/HORA</th>
                            <th style=\"width: 10%\">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Filas dinámicas -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Sección MATERIALES -->
        <div class=\"card mb-3\">
            <div class=\"card-header bg-success text-white\">
                <i class=\"bi bi-box-seam\"></i> Materiales
                <button type=\"button\" class=\"btn btn-sm btn-light float-end\" onclick=\"addMaterialRow()\">
                    <i class=\"bi bi-plus\"></i> Agregar
                </button>
            </div>
            <div class=\"card-body\">
                <table class=\"table table-sm\" id=\"materialTable\">
                    <thead>
                        <tr>
                            <th style=\"width: 40%\">Descripción</th>
                            <th style=\"width: 15%\">Unidad</th>
                            <th style=\"width: 20%\">Cantidad</th>
                            <th style=\"width: 15%\">Precio Unit.</th>
                            <th style=\"width: 10%\">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Filas dinámicas -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Sección TRANSPORTE -->
        <div class=\"card mb-3\">
            <div class=\"card-header bg-secondary text-white\">
                <i class=\"bi bi-truck\"></i> Transporte
                <button type=\"button\" class=\"btn btn-sm btn-light float-end\" onclick=\"addTransportRow()\">
                    <i class=\"bi bi-plus\"></i> Agregar
                </button>
            </div>
            <div class=\"card-body\">
                <table class=\"table table-sm\" id=\"transportTable\">
                    <thead>
                        <tr>
                            <th style=\"width: 30%\">Descripción</th>
                            <th style=\"width: 15%\">Unidad</th>
                            <th style=\"width: 15%\">Cantidad</th>
                            <th style=\"width: 15%\">DMT (km)</th>
                            <th style=\"width: 15%\">Tarifa/km</th>
                            <th style=\"width: 10%\">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Filas dinámicas -->
                    </tbody>
                </table>
            </div>
        </div>

        <div class=\"text-end\">
            <button type=\"button\" class=\"btn btn-outline-secondary\" onclick=\"history.back()\">Cancelar</button>
            <button type=\"submit\" class=\"btn btn-primary\">
                <i class=\"bi bi-save\"></i> Guardar APU
            </button>
        </div>
    </form>
</div>

<script>
let equipmentIndex = 0;
let laborIndex = 0;
let materialIndex = 0;
let transportIndex = 0;

function addEquipmentRow() {
    const tbody = document.querySelector('#equipmentTable tbody');
    const row = document.createElement('tr');
    row.innerHTML = `
        <td><input type=\"text\" class=\"form-control form-control-sm\" name=\"equipment[\${equipmentIndex}][descripcion]\" required></td>
        <td><input type=\"number\" class=\"form-control form-control-sm\" name=\"equipment[\${equipmentIndex}][numero]\" required></td>
        <td><input type=\"number\" step=\"0.01\" class=\"form-control form-control-sm\" name=\"equipment[\${equipmentIndex}][tarifa]\" required></td>
        <td><input type=\"number\" step=\"0.0001\" class=\"form-control form-control-sm\" name=\"equipment[\${equipmentIndex}][c_hora]\" required></td>
        <td><button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"this.closest('tr').remove()\"><i class=\"bi bi-trash\"></i></button></td>
    `;
    tbody.appendChild(row);
    equipmentIndex++;
}

function addLaborRow() {
    const tbody = document.querySelector('#laborTable tbody');
    const row = document.createElement('tr');
    row.innerHTML = `
        <td><input type=\"text\" class=\"form-control form-control-sm\" name=\"labor[\${laborIndex}][descripcion]\" required></td>
        <td><input type=\"number\" class=\"form-control form-control-sm\" name=\"labor[\${laborIndex}][numero]\" required></td>
        <td><input type=\"number\" step=\"0.0001\" class=\"form-control form-control-sm\" name=\"labor[\${laborIndex}][jor_hora]\" required></td>
        <td><input type=\"number\" step=\"0.01\" class=\"form-control form-control-sm\" name=\"labor[\${laborIndex}][c_hora]\" required></td>
        <td><button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"this.closest('tr').remove()\"><i class=\"bi bi-trash\"></i></button></td>
    `;
    tbody.appendChild(row);
    laborIndex++;
}

function addMaterialRow() {
    const tbody = document.querySelector('#materialTable tbody');
    const row = document.createElement('tr');
    row.innerHTML = `
        <td><input type=\"text\" class=\"form-control form-control-sm\" name=\"materials[\${materialIndex}][descripcion]\" required></td>
        <td><input type=\"text\" class=\"form-control form-control-sm\" name=\"materials[\${materialIndex}][unidad]\" required></td>
        <td><input type=\"number\" step=\"0.0001\" class=\"form-control form-control-sm\" name=\"materials[\${materialIndex}][cantidad]\" required></td>
        <td><input type=\"number\" step=\"0.01\" class=\"form-control form-control-sm\" name=\"materials[\${materialIndex}][precio_unitario]\" required></td>
        <td><button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"this.closest('tr').remove()\"><i class=\"bi bi-trash\"></i></button></td>
    `;
    tbody.appendChild(row);
    materialIndex++;
}

function addTransportRow() {
    const tbody = document.querySelector('#transportTable tbody');
    const row = document.createElement('tr');
    row.innerHTML = `
        <td><input type=\"text\" class=\"form-control form-control-sm\" name=\"transport[\${transportIndex}][descripcion]\" required></td>
        <td><input type=\"text\" class=\"form-control form-control-sm\" name=\"transport[\${transportIndex}][unidad]\" required></td>
        <td><input type=\"number\" step=\"0.0001\" class=\"form-control form-control-sm\" name=\"transport[\${transportIndex}][cantidad]\" required></td>
        <td><input type=\"number\" step=\"0.01\" class=\"form-control form-control-sm\" name=\"transport[\${transportIndex}][dmt]\" required></td>
        <td><input type=\"number\" step=\"0.01\" class=\"form-control form-control-sm\" name=\"transport[\${transportIndex}][tarifa_km]\" required></td>
        <td><button type=\"button\" class=\"btn btn-sm btn-danger\" onclick=\"this.closest('tr').remove()\"><i class=\"bi bi-trash\"></i></button></td>
    `;
    tbody.appendChild(row);
    transportIndex++;
}

// Agregar al menos una fila inicial en cada sección
addEquipmentRow();
addLaborRow();
addMaterialRow();
addTransportRow();
</script>
{% endblock %}
", "apu/create.html.twig", "/var/www/html/proyecto/templates/apu/create.html.twig");
    }
}
