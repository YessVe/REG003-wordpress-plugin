<?php
//Define class_name
//Each function will be called later, when needed
class shortCode{
  
  public function formulario($atts){

    global $wpdb;
    //$index = get the last register from table "wp_settings"
      $index = $wpdb->get_var("SELECT * FROM `wp_settings` ORDER BY SettingsId DESC LIMIT 1";
    //$secretKey = get variable 'SecretKey'  from table "wp_settings" of the last register
      $secretKey = $wpdb->get_var("SELECT `SecretKey` FROM `wp_settings` WHERE `SettingsId`= $index ");

    $paymentUrl =  plugins_url("wordpressProject/paymentProcessed.php", "" ); //path to ajax
    $styletUrl =  plugins_url("wordpressProject/admin/styless.css", "" ); //path style file
  
    return '
    <html>
    <head>
    <link rel="stylesheet" type="text/css" href="'. $styletUrl .'">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    </head>
    <body>
      <div class="donation-plugin-modal" >
      <h2 style="color:#e13e3f; text-align:center">'
          . $atts .
          '</h2><br/>
          <form method="post" style="text-align: center;">
          <input type="number" id="amount" name="importe" placeholder="Monto a aportar" class="inputFormClient" /><br /><br />
          <input class="inputFormClient" type="text" id="name" name="your_name" placeholder="Nombre completo" class="inputFormClient"/><br /><br />
          <input type="email" id="email" name="your_email" placeholder="Email" class="inputFormClient"/><br /><br />
          <input type="number" id="phone" name="phone" placeholder="Número de teléfono" class="inputFormClient"/><br /><br />
          <input type="text" id="description" name="description" placeholder="Concepto de donación" class="inputFormClient"/><br /><br />
          <input type="submit" id="buyButton" name="submit" value="DONAR" /><br /><br />
      </form>

      <script>
     
      if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
      }
      // obtener los datos del formulario
      let dp_amount = "";
      let dp_name = "";
      let dp_email = "";
      let dp_phone = "";
      let dp_description = "";
      // Usa la funcion Culqi.open() en el evento que desees
      $("#buyButton").on("click", function(e) {
        dp_amount = document.getElementById("amount").value*100;
        dp_name = document.getElementById("name").value;
        dp_email = document.getElementById("email").value;
        dp_phone = document.getElementById("phone").value;
        dp_description = document.getElementById("description").value;
        // Configura tu llave pública
        //Culqi.publicKey = tokenPublicKey ;
        Culqi.publicKey ="'. $secretKey.'" ;
        // Configura tu Culqi Checkout
        Culqi.settings({
            title: "Culqi Store",
            currency: "PEN",
            description: dp_description,
            amount: dp_amount,
        });
        // Abre el formulario con las opciones de Culqi.settings
        Culqi.open();
        e.preventDefault();
      });
      function culqi() {
        if (Culqi.token) { // ¡Objeto Token creado exitosamente!
            let token = Culqi.token.id;
            let email = Culqi.token.email;
            //alert("Se ha creado un token:" + token);
            //En esta linea de codigo debemos enviar el "Culqi.token.id"
            //hacia tu servidor con Ajax debemos enviar todos los datos que usaremos
            $.ajax({
              url: "'. $paymentUrl .'",
              type: "POST",
              data: {
                description: dp_description,
                amount: dp_amount,
                amount2:dp_amount/100,
                token: token,
                email: email,
                phone: dp_phone,
                name: dp_name,
                tokenSecretKey: "'. $secretKey.'"
              }
            }).done(function(resp){
              alert(resp);
            });
        } else { // ¡Hubo algún problema!
            // Mostramos JSON de objeto error en consola
            console.log(Culqi.error);
            alert(Culqi.error.user_message);
        }
      };
    
      </script>
      </div>
      <script src="https://checkout.culqi.com/js/v3"></script>
      </body>
      
    </html>
    ';
      
    }
  }

  ?>