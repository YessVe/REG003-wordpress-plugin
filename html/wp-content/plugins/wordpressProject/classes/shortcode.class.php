.<?php
    $paymentUrl =  plugins_url("wordpressProject/paymentProcessed.php", "" );
    //echo $paymentUrl;

class shortCode{
  public function formulario($atts){
    error_log("shortcode");
  //attributes
  return '
  <html>
  <head>
  <script src="https://checkout.culqi.com/js/v3"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  </head>
  <body>
    <div class="donation-plugin-modal" style="display: block; background: #362277; padding: 20px; border-radius: 10px; width:30%">
    <h2 style="color:#e13e3f; text-align:center">'
    . $atts .
    '</h2><br/>
    <form method="post" style="text-align: center;">
        <input type="number" id="amount" name="importe" placeholder="Monto a aportar" style="border-radius: 10px; border: none; outline: none; width: 100%"/><br /><br />
        <input type="text" id="name" name="your_name" placeholder="Nombre completo" style="border-radius: 10px; border: none;  outline: none; width: 100%" /><br /><br />
        <input type="email" id="email" name="your_email" placeholder="Email" style="border-radius: 10px; border: none;  outline: none ; width: 100%" /><br /><br />
        <input type="number" id="phone" name="phone" placeholder="Número de teléfono" style="border-radius: 10px; border: none;  outline: none; width: 100%" /><br /><br />
        <input type="text" id="description" name="description" placeholder="Concepto de donación" style="border-radius: 10px; border: none;  outline: none; width: 100%" /><br /><br />
        <input type="submit" id="buyButton" name="submit" value="DONAR" style="border-radius: 10px; border: none; color: #362277; font-weight: bolder;background: #abe1c1;  outline: none ; width: 100%" /><br /><br />
    </form>
    
    <form id ="form_1" method="post" style="text-align: center; display:none" >
      <input type="number" id="amount" name="amount2" placeholder="Monto a aportar"/><br /><br />

      <input type="text" id="name" name="name2" placeholder="Nombre completo"/><br /><br />

      <input type="email" id="email" name="email2" placeholder="Email"/><br /><br />

      <input type="number" id="phone" name="phone2" placeholder="Número de teléfono"/><br /><br />

      <input type="text" id="description" name="description2" placeholder="Concepto de donación"/><br /><br />

      <input type="text" id="token" name="token"/><br /><br />

      <input type="submit" id="buyButton01" name="submit01" value="DONAR"/><br /><br />
    </form>


    <script>

    

    let dp_amount = "";
    let dp_name = "";
    let dp_email = "";
    let dp_phone = "";
    let dp_description = "";
    // Usa la funcion Culqi.open() en el evento que desees
    $("#buyButton").on("click", function(e) {

      dp_amount = parseInt(document.getElementById("amount").value*100);
      dp_name = document.getElementById("name").value;
      dp_email = document.getElementById("email").value;
      dp_phone = document.getElementById("phone").value;
      dp_description = document.getElementById("description").value;

      // Configura tu llave pública
      Culqi.publicKey = "pk_test_87a7198984bae065";
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

        document.forms[2].elements["amount"].value = dp_amount;
        document.forms[2].elements["name"].value = dp_name;
        document.forms[2].elements["email"].value = dp_email;
        document.forms[2].elements["description"].value = dp_description;
        document.forms[2].elements["token"].value = token;

          let token = Culqi.token.id;
          let email = Culqi.token.email;
          alert("Se ha creado un token:" + token);
          //En esta linea de codigo debemos enviar el "Culqi.token.id"
          //hacia tu servidor con Ajax
          
          const form01= document.getElementById("form_1");
          form01.submit();

      } else { // ¡Hubo algún problema!
          // Mostramos JSON de objeto error en consola
          console.log(Culqi.error);
          alert(Culqi.error.user_message);
      }
    };
  
    </script>
    </div>
  </body>
  </html>
    ';

  }
}

?>