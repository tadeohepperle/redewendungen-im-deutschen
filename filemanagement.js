const fs = require("fs");

async function readObjFromFile(filepath) {
  const res = await fs.promises.readFile(filepath, "utf-8");
  return JSON.parse(res);
}

async function writeObjToFile(filepath, obj) {
  let jsonstring = JSON.stringify(obj);
  await fs.promises.writeFile(filepath, jsonstring, "utf-8");
}

module.exports.readObjFromFile = readObjFromFile;
module.exports.writeObjToFile = writeObjToFile;
