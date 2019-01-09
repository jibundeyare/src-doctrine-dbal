<?php
// public/hello-doctrine-dbal.php

// déclaration des classes PHP qui seront utilisées
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;

// activation de la fonction autoloading de Composer
require __DIR__.'/../vendor/autoload.php';

// instanciation du chargeur de templates
$loader = new Twig_Loader_Filesystem(__DIR__.'/../templates');
// instanciation du moteur de template
$twig = new Twig_Environment($loader);

// création d'une variable avec une configuration par défaut
$config = new Configuration();

// création d'un tableau avec les paramètres de connection à la BDD
$connectionParams = [
    'driver'    => 'pdo_mysql',
    'host'      => '127.0.0.1',
    'port'      => '3306',
    'dbname'    => 'src_sql',
    'user'      => 'root',
    'password'  => '123',
    'charset'   => 'utf8mb4',
];

// connection à la BDD
// la variable `$conn` permet de communiquer avec la BDD
$conn = DriverManager::getConnection($connectionParams, $config);

// envoi d'une requête SQL à la BDD et récupération du résultat sous forme de tableau PHP dans la variable `$items`
$students = $conn->fetchAll('SELECT * FROM student');
$projects = $conn->fetchAll('SELECT * FROM project');

$sql = 'SELECT *, student.id AS student_id, project.id AS project_id
FROM student
INNER JOIN project ON project.id = student.project_id';

$studentsWithProject = $conn->fetchAll($sql);

// affichage du rendu d'un template
echo $twig->render('hello-doctrine-dbal.html.twig', [
    // transmission de données au template
    'students' => $students,
    'projects' => $projects,
    'studentsWithProject' => $studentsWithProject,
]);
