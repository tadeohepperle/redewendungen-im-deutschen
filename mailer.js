const nodemailer = require("nodemailer");
const fs = require("fs");
const { readObjFromFile, writeObjToFile } = require("./filemanagement");

// async..await is not allowed in global scope, must use a wrapper
main();

async function main() {
  let chosenSaying = await getChosenSayingForDay();
  let html = createHTMLForEmail("tadeo@do-mix.de", chosenSaying);
  await sendMail("tadeo@do-mix.de", "Deine tägliche Redewendung", html);
}

async function getChosenSayingForDay() {
  let allSayings = await readObjFromFile("./data/redewendungen_shuffled.json");
  let now = new Date("2020-12-23");
  let fullDaysSinceEpoch = Math.floor(now / 8.64e7);
  randomIndex = fullDaysSinceEpoch % allSayings.length;
  return allSayings[randomIndex];
}

async function sendMail(to, subject, html) {
  let CONFIG = await readObjFromFile("./config.json");
  console.log(CONFIG);
  return new Promise((resolve, reject) => {
    var transporter = nodemailer.createTransport({
      host: "mail.gmx.com",
      port: 587,
      tls: {
        ciphers: "SSLv3",
        rejectUnauthorized: false,
      },
      debug: true,
      auth: {
        user: CONFIG.gmxusername,
        pass: CONFIG.gmxpassword,
      },
    });

    var mailOptions = {
      from: CONFIG.gmxusername,
      to,
      subject,
      html,
    };

    transporter.sendMail(mailOptions, function (error, info) {
      if (error) {
        console.log(error);
        reject(error);
      } else {
        resolve(info);
        console.log("Email sent: " + info.response);
      }
    });
  });
}

function createHTMLForEmail(to, chosenSaying) {
  let unsubscribehref = "www.google.com";

  let html = `
  <!DOCTYPE html>

<html lang="de">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=, initial-scale=1.0" />
    <title>Deutsche Redensarten lernen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</head>

<body>
    <style>
        #quote {
            font-style: italic;
        }

        #credit {
            font-size: 12px;
        }
    </style>
    <nav class="navbar bg-success navbar-dark">
        <div class="container" style="position: relative">
            <div class="text-center navbar-brand" style="width: 100%">
                Deine tägliche Redewendung:
            </div>
           
        </div>
    </nav>
    <div class="container">
        <h1 class="p-4 mt-4 mb-4 text-center" id="quote">
            "${chosenSaying.title}"
        </h1>
    </div>
    <div class=" text-dark mb-4 ">
        <div class="container bg-light shadow-sm rounded">
            <div class="p-4 mt-4">
                <h2>Bedeutung:</h2>
                <p class="">
                  ${chosenSaying.meanings[0]}
                </p>
            </div>
        </div>
    </div>
    ${
      !(chosenSaying["examples"].length > 0)
        ? ``
        : `<div class=" text-dark mb-4 ">
    <div class="container bg-light shadow-sm rounded">
        <div class="p-4 mt-4">
            <h2>Beispiel:</h2>
            ${chosenSaying["examples"]
              .map(
                (example) => ` <p>
            ${example}
        </p>`
              )
              .join("\n")}
            
        </div>
    </div>
</div>`
    }
        

    
    <nav class="navbar fixed-bottom navbar-dark bg-dark">
        <div class="container">
            <div class="text-center navbar-brand" style="width: 100%; font-size: 16px">
                <a href="${unsubscribehref}" style="color: #bbb; text-decoration: none">Keine Redewendungen mehr erhalten.</a>
            </div>
        </div>
    </nav>
</body>

</html>`;

  return html;
}
