const fs = require("fs");
const {
  exampleHTML,
  exampleHTML2,
  alleRedewendungenHTML,
} = require("./exampledata");
const axios = require("axios");
const cheerio = require("cheerio");
const { title } = require("process");
const { readObjFromFile, writeObjToFile } = require("./filemanagement");

async function scrapeAllRedewendungenDataFromWiktionary() {
  const FILEPATH = "./data/redewendungen2.json";
  const WIKTIONARYURL = "https://de.wiktionary.org/";
  const alleLinks = await readObjFromFile("./data/alleRedewendungenLinks.json");
  console.log(alleLinks);
  for (let i = 0; i < alleLinks.length; i++) {
    let url = WIKTIONARYURL + alleLinks[i];
    console.log(url);
    let obj = await wiktionaryURLToDataObject(url);
    if (obj) {
      try {
        let total = await readObjFromFile(FILEPATH);
        total.push(obj);
        await writeObjToFile(FILEPATH, total);
      } catch (err) {
        console.log(err);
      }
    }
  }
}

scrapeAllRedewendungenDataFromWiktionary();

// const alleLinks = [];
// let $ = cheerio.load(alleRedewendungenHTML);
// $("a").each((i, a) => {
//   let href = $(a).attr("href");
//   if (!$(a).hasClass("new")) alleLinks.push(href);
// });
// writeObjToFile("alleRedewendungenLinks.json", alleLinks);

// console.log(alleLinks);
function stripTags(str) {
  return str.replace(/(<([^>]+)>)/gi, "");
}

async function wiktionaryURLToDataObject(url) {
  let html = await URlToHTML(url);
  let obj = wiktionaryHTMLToDataObject(html, url);
  return obj;
}

async function URlToHTML(url) {
  try {
    res = await axios.get(url);
    if (res.status === 200) {
      return res.data;
    }
  } catch (err) {
    console.error(err);
  }
  return null;
}

function wiktionaryHTMLToDataObject(html, url) {
  let obj = {
    url,
    meanings: [],
    synonyms: [],
    title: "",
    opposites: [],
    examples: [],
    sayings: [],
    herkunft: [],
  };
  try {
    let $ = cheerio.load(html);
    obj.title = $("h1").text();
    $ = cheerio.load($(".mw-parser-output").html());
    let psAndDLs = [];
    $(`p[style="margin-bottom:-0.5em; font-weight:bold;"]`).each((i, p) => {
      let dl = p.nextSibling;
      while (dl.type != "tag") {
        // wir müssen whitespace überspringen, was auch als node gewertet wird
        dl = dl.nextSibling;
      }
      psAndDLs.push([$(p).html(), dl]);
    });
    psAndDLs.forEach((pAndDL) => {
      const [title, dl] = pAndDL;
      if (title == "Aussprache:") {
        $("a", dl).each((i, a) => {
          if (i == 2) {
            obj.mp3Title = $(a).attr("title");
            obj.mp3Scr = $(a).attr("href");
          }
        });
      }
      if (title == "Bedeutungen:") {
        $("dd", dl).each((i, dd) => {
          let ddhtml = $(dd).html();
          ddhtml = stripTags(ddhtml);
          ddhtml = ddhtml.replace(/(\[([^\]]+)\])/gi, "").trim();
          obj.meanings.push(ddhtml);
        });
      }
      if (title == "Synonyme:") {
        $("dd", dl).each((i, dd) => {
          let ddhtml = $(dd).html();
          ddhtml = stripTags(ddhtml);
          ddhtml = ddhtml.replace(/(\[([^\]]+)\])/gi, "").trim();
          obj.synonyms.push(ddhtml);
        });
      }
      if (title == "Herkunft:") {
        $("dd", dl).each((i, dd) => {
          let ddhtml = $(dd).html();
          ddhtml = stripTags(ddhtml);
          ddhtml = ddhtml.replace(/(\[([^\]]+)\])/gi, "").trim();
          obj.herkunft.push(ddhtml);
        });
      }
      if (title == "Gegenwörter:") {
        $("dd", dl).each((i, dd) => {
          let ddhtml = $(dd).html();
          ddhtml = stripTags(ddhtml);
          ddhtml = ddhtml.replace(/(\[([^\]]+)\])/gi, "").trim();
          obj.opposites.push(ddhtml);
        });
      }
      if (title == "Beispiele:") {
        $("dd", dl).each((i, dd) => {
          let ddhtml = $(dd).html();
          ddhtml = stripTags(ddhtml);
          ddhtml = ddhtml.replace(/(\[([^\]]+)\])/gi, "").trim();
          obj.examples.push(ddhtml);
        });
      }
      if (title == "Redewendungen:") {
        $("dd", dl).each((i, dd) => {
          let ddhtml = $(dd).html();
          ddhtml = stripTags(ddhtml);
          ddhtml = ddhtml.replace(/(\[([^\]]+)\])/gi, "").trim();
          obj.sayings.push(ddhtml);
        });
      }
    });

    // console.log($.html());
    return obj;
  } catch (err) {
    console.error(err);
    return null;
  }
}
