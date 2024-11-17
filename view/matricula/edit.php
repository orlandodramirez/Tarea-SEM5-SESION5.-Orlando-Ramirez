<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/semana5/tallermvcphp/routes.php');
session_start();

if (!isset($_SESSION["usuario"])) {
    header('location: ../usuario/login.php');
}

$Usuario = $_SESSION["usuario"];

require_once(CONTROLLER_PATH . 'matriculaController.php');
$object = new matriculaController();
$idMatricula = $_GET['id'];
$matricula = $object->search($idMatricula);
$estudiantes = $object->combolistEstudiantes();
$usuarios = $object->combolistUsuario($Usuario);
$cursos = $object->combolistCursos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
    <title>Matriculas</title>
</head>
<body>
    <?php require_once(VIEW_PATH . 'navbar/navbar.php'); ?>

    <div class="container">
        <div class="mb-3">
            <h2>Editando registro</h2>
        </div>
        <form id="formPersona" action="update.php" method="post" class="g-3 needs-validation" novalidate>
            <div class="mb-3">
                <label for="id" class="form-label">ID Matricula</label>
                <input value="<?= $matricula['idMatricula'] ?>" type="text" class="form-control" id="id" name="id" readonly>
            </div>

            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha</label>
                <input value="<?= $matricula['fecha'] ?>" type="date" class="form-control" id="fecha" name="fecha" autofocus required>
                <div class="invalid-feedback">Ingrese o seleccione una fecha válida!</div>
            </div>

            <div class="mb-3">
                <label for="idEstudiante" class="form-label">Estudiante</label>
                <select class="form-control" name="idEstudiante" id="idEstudiante" required>
                    <option selected disabled value="">No especificado</option>
                    <?php foreach ($estudiantes as $estudiante) : ?>
                        <option value="<?= $estudiante['idEstudiante'] ?>" <?= $matricula['idEstudiante'] == $estudiante['idEstudiante'] ? 'selected' : '' ?>>
                            <?= $estudiante['estudiante'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">Seleccione un elemento válido!</div>
            </div>

            <div class="mb-3">
                <label for="idUsuario" class="form-label">Usuario</label>
                <select class="form-control" name="idUsuario" id="idUsuario">
                    <?php foreach ($usuarios as $user) : ?>
                        <option value="<?= $user['idUsuario'] ?>" <?= $user['idUsuario'] == $matricula['idUsuario'] ? 'selected' : '' ?>>
                            <?= $user['idUsuario'] . " - " . $user['alias'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">Seleccione un elemento válido!</div>
            </div>

            <div class="mb-3">
                <label for="idCurso" class="form-label">Curso</label>
                <select class="form-control" name="idCurso" id="idCurso" required>
                    <option selected disabled value="">No especificado</option>
                    <?php foreach ($cursos as $curso) : ?>
                        <option value="<?= $curso['idCurso'] ?>" <?= $matricula['idCurso'] == $curso['idCurso'] ? 'selected' : '' ?>>
                            <?= $curso['nombre'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">Seleccione un elemento válido!</div>
            </div>

            <button type="submit" class="btn btn-primary btn-lg col-4">Guardar</button>
        </form>
    </div>

    <script src="../../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/js/jquery.min.js"></script>
    <script src="../../assets/js/validate.js"></script>
</body>
</html>
