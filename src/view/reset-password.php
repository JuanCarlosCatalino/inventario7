<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Recuperar Contraseña - Papayal</title>
<script>
  const base_url = '<?php echo BASE_URL;?>';
  const base_url_server = '<?php echo BASE_URL_SERVER;?>';
</script>
  <style>
    body {
      background-color: #fdf8f3;
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 450px;
      margin: 80px auto;
      background-color: #ffffff;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
      border-top: 8px solid #ffa726;
    }

    h2 {
      text-align: center;
      color: #ffa726;
      margin-bottom: 30px;
    }

    label {
      font-weight: 600;
      color: #444;
      display: block;
      margin-top: 15px;
    }

    input[type="email"] {
      width: 100%;
      padding: 12px;
      margin-top: 8px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 1em;
      background-color: #fefefe;
    }

    button {
      width: 100%;
      padding: 14px;
      margin-top: 25px;
      background-color: #66bb6a;
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 1.1em;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    button:hover {
      background-color: #558b2f;
    }

    .footer {
      margin-top: 30px;
      text-align: center;
      font-size: 0.9em;
      color: #aaa;
    }
  </style>
</head>
<body>
    <input type="hidden" id="data" value="<?php echo $_GET['data'];?>">
    <input type="hidden" id="data2" value="<?php echo urldecode( $_GET['data2']); ?>">


  <div class="container" >
    <h2 class="form-content">Recuperar Contraseña</h2>
    <form id="frm_reset-password">
      
      <input type="text" id="password" name="password" placeholder="nueva contraseña" required>
      <input type="text" id="password1" name="password1" placeholder="confirmar contraseña" required>

      <button type="button" onclick="validar_inputs_password()">Actualizar contraseña</button>

    </form>

    <div class="footer">
      © 2025 Papayal 
    </div>
  </div>

</body>
<<script src="<?php echo BASE_URL; ?>src/view/js/principal.js"></script>
<script>
  validar_datos_reset_password();
</script>
<!-- Sweet Alerts Js-->
<script src="<?php echo BASE_URL ?>src/view/pp/plugins/sweetalert2/sweetalert2.min.js"></script>
</html>
