<?php



header('Access-Control-Allow-Origin: http://localhost:3000'); 
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS'); 
header('Access-Control-Allow-Headers: Content-Type, Authorization'); 
header('Access-Control-Allow-Credentials: true'); 

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit;
}

session_start();
$_SESSION['user_id'] = 1;
// Vérifier si l'utilisateur est authentifié
// if (!isset($_SESSION['user_id'])) {
//     http_response_code(401); // Unauthorized
//     echo json_encode(['success' => false, 'message' => 'Non autorisé']);
//     exit();
// }

require_once 'dbconnect.php';

$method = $_SERVER['REQUEST_METHOD'];
$id = $_GET['id'] ?? null;

switch ($method) {
    case 'GET':
        if ($id) {
            $stmt = $pdo->prepare("SELECT * FROM compteurs WHERE id = ?");
            $stmt->execute([$id]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $stmt = $pdo->query("SELECT * FROM compteurs");
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        echo json_encode(['success' => true, 'data' => $data]);
        break;

    case 'POST':
        $input = json_decode(file_get_contents("php://input"), true);
        $stmt = $pdo->prepare("INSERT INTO compteurs (nom_proprietaire, numero_voie, nom_voie, code_postal, ville, code_insee)
                               VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $input['nom_proprietaire'],
            $input['numero_voie'],
            $input['nom_voie'],
            $input['code_postal'],
            $input['ville'],
            $input['code_insee']
        ]);
        echo json_encode(['success' => true, 'message' => 'Compteur ajouté']);
        break;

    case 'PUT':
        if (!$id) {
            echo json_encode(['success' => false, 'message' => 'ID manquant']);
            exit;
        }
        $input = json_decode(file_get_contents("php://input"), true);
        $stmt = $pdo->prepare("UPDATE compteurs SET 
            nom_proprietaire = ?, 
            numero_voie = ?, 
            nom_voie = ?, 
            code_postal = ?, 
            ville = ?, 
            code_insee = ?
            WHERE id = ?");
        $stmt->execute([
            $input['nom_proprietaire'],
            $input['numero_voie'],
            $input['nom_voie'],
            $input['code_postal'],
            $input['ville'],
            $input['code_insee'],
            $id
        ]);
        echo json_encode(['success' => true, 'message' => 'Compteur modifié']);
        break;

    case 'DELETE':
        if (!$id) {
            echo json_encode(['success' => false, 'message' => 'ID manquant']);
            exit;
        }
        $stmt = $pdo->prepare("DELETE FROM compteurs WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['success' => true, 'message' => 'Compteur supprimé']);
        break;

    default:
        http_response_code(405);
        echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
        break;
}
?>
