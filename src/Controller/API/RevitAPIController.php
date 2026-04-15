<?php

namespace App\Controller\API;

use App\Entity\Tenant;
use App\Entity\User;
use App\Service\EncryptionService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use DateTimeImmutable;

#[Route('/api/v2')]
class RevitAPIController extends AbstractController
{
    private Configuration $jwtConfig;

    public function __construct(
        private EntityManagerInterface $em,
        private UserPasswordHasherInterface $passwordHasher,
        string $jwtSecret
    ) {
        $this->jwtConfig = Configuration::forSymmetricSigner(
            new Sha256(),
            InMemory::plainText($jwtSecret)
        );
    }

    #[Route('/auth/login', name: 'api_revit_login', methods: ['POST'])]
    public function login(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['email'], $data['password'], $data['api_key'])) {
            return $this->json([
                'success' => false,
                'error' => [
                    'code' => 'INVALID_REQUEST',
                    'message' => 'Faltan parámetros: email, password, api_key'
                ]
            ], Response::HTTP_BAD_REQUEST);
        }

        // Verificar usuario
        $user = $this->em->getRepository(User::class)->findOneBy(['email' => $data['email']]);

        if (!$user || !$user->isActive()) {
            return $this->json([
                'success' => false,
                'error' => [
                    'code' => 'AUTH_FAILED',
                    'message' => 'Credenciales inválidas'
                ]
            ], Response::HTTP_UNAUTHORIZED);
        }

        // Verificar contraseña
        if (!$this->passwordHasher->isPasswordValid($user, $data['password'])) {
            return $this->json([
                'success' => false,
                'error' => [
                    'code' => 'AUTH_FAILED',
                    'message' => 'Credenciales inválidas'
                ]
            ], Response::HTTP_UNAUTHORIZED);
        }

        // TODO: Verificar API Key del tenant
        // Por ahora simplificado

        // Generar JWT Token
        $now = new DateTimeImmutable();
        $token = $this->jwtConfig->builder()
            ->issuedBy($request->getSchemeAndHttpHost())
            ->permittedFor($request->getSchemeAndHttpHost())
            ->identifiedBy(\bin2hex(\random_bytes(16)))
            ->issuedAt($now)
            ->expiresAt($now->modify('+1 hour'))
            ->withClaim('user_id', $user->getId())
            ->withClaim('email', $user->getEmail())
            ->withClaim('tenant', $user->getTenant()->getSlug())
            ->withClaim('role', $user->getRole())
            ->getToken($this->jwtConfig->signer(), $this->jwtConfig->signingKey());

        return $this->json([
            'success' => true,
            'data' => [
                'access_token' => $token->toString(),
                'token_type' => 'Bearer',
                'expires_in' => 3600,
                'user' => [
                    'id' => $user->getId(),
                    'email' => $user->getEmail(),
                    'tenant' => $user->getTenant()->getSlug(),
                    'role' => $user->getRole()
                ]
            ]
        ]);
    }

    #[Route('/projects', name: 'api_revit_create_project', methods: ['POST'])]
    public function createProject(Request $request): JsonResponse
    {
        // Verificar token JWT
        $token = $this->validateJWT($request);
        if (!$token) {
            return $this->json([
                'success' => false,
                'error' => ['code' => 'UNAUTHORIZED', 'message' => 'Token inválido']
            ], Response::HTTP_UNAUTHORIZED);
        }

        $data = json_decode($request->getContent(), true);

        if (!isset($data['project_name'])) {
            return $this->json([
                'success' => false,
                'error' => ['code' => 'INVALID_REQUEST', 'message' => 'Falta project_name']
            ], Response::HTTP_BAD_REQUEST);
        }

        // Crear proyecto BIM (entidad a crear)
        // Por ahora retornamos respuesta simulada

        $projectId = \rand(1000, 9999);
        $projectUuid = sprintf('%04x%04x-%04x-%04x', \mt_rand(0, 0xffff), \mt_rand(0, 0xffff), \mt_rand(0, 0xffff), \mt_rand(0, 0xffff));

        return $this->json([
            'success' => true,
            'data' => [
                'project_id' => $projectId,
                'project_uuid' => $projectUuid,
                'message' => 'Proyecto creado exitosamente',
                'sync_url' => "/api/v2/projects/{$projectId}/sync"
            ]
        ], Response::HTTP_CREATED);
    }

    #[Route('/projects/{projectId}/elements', name: 'api_revit_send_elements', methods: ['POST'])]
    public function sendElements(Request $request, int $projectId): JsonResponse
    {
        $token = $this->validateJWT($request);
        if (!$token) {
            return $this->json([
                'success' => false,
                'error' => ['code' => 'UNAUTHORIZED', 'message' => 'Token inválido']
            ], Response::HTTP_UNAUTHORIZED);
        }

        $data = json_decode($request->getContent(), true);

        if (!isset($data['elements']) || !is_array($data['elements'])) {
            return $this->json([
                'success' => false,
                'error' => ['code' => 'INVALID_REQUEST', 'message' => 'Faltan elementos']
            ], Response::HTTP_BAD_REQUEST);
        }

        $elementsCount = count($data['elements']);

        // Aquí se guardarían los elementos en la BD
        // Por ahora retornamos respuesta simulada

        return $this->json([
            'success' => true,
            'data' => [
                'elements_imported' => $elementsCount,
                'elements_updated' => 0,
                'elements_failed' => 0,
                'calculation_status' => 'pending',
                'message' => 'Elementos importados. Cálculos en proceso.'
            ]
        ], Response::HTTP_CREATED);
    }

    #[Route('/projects/{projectId}/calculations', name: 'api_revit_get_calculations', methods: ['GET'])]
    public function getCalculations(Request $request, int $projectId): JsonResponse
    {
        $token = $this->validateJWT($request);
        if (!$token) {
            return $this->json([
                'success' => false,
                'error' => ['code' => 'UNAUTHORIZED', 'message' => 'Token inválido']
            ], Response::HTTP_UNAUTHORIZED);
        }

        // Obtener cálculos de APU para el proyecto
        // Por ahora respuesta simulada

        return $this->json([
            'success' => true,
            'data' => [
                'project_id' => $projectId,
                'total_calculations' => 0,
                'calculations' => [],
                'summary' => [
                    'total_cost' => 0,
                    'materials_cost' => 0,
                    'labor_cost' => 0,
                    'equipment_cost' => 0
                ],
                'pagination' => [
                    'current_page' => 1,
                    'per_page' => 50,
                    'total_pages' => 0,
                    'total_items' => 0
                ]
            ]
        ]);
    }

    private function validateJWT(Request $request): ?array
    {
        $authHeader = $request->headers->get('Authorization');

        if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
            return null;
        }

        $tokenString = substr($authHeader, 7);

        try {
            $token = $this->jwtConfig->parser()->parse($tokenString);

            $constraints = [
                new \Lcobucci\JWT\Validation\Constraint\SignedWith(
                    $this->jwtConfig->signer(),
                    $this->jwtConfig->signingKey()
                ),
                new \Lcobucci\JWT\Validation\Constraint\LooseValidAt(
                    new \Lcobucci\Clock\SystemClock(new \DateTimeZone('UTC'))
                ),
            ];

            if (!$this->jwtConfig->validator()->validate($token, ...$constraints)) {
                return null;
            }

            return [
                'user_id' => $token->claims()->get('user_id'),
                'email'   => $token->claims()->get('email'),
                'tenant'  => $token->claims()->get('tenant'),
                'role'    => $token->claims()->get('role'),
            ];
        } catch (\Exception $e) {
            return null;
        }
    }
}
