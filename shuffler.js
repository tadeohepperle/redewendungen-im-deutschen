const fs = require("fs");
const { readObjFromFile, writeObjToFile } = require("./filemanagement");

async function main() {
  let arr = await readObjFromFile("./data/redewendungen.json");
  for (let i = arr.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * i);
    const temp = arr[i];
    arr[i] = arr[j];
    arr[j] = temp;
  }
  await writeObjToFile("./data/redewendungen_shuffled.json", arr);
  console.log(arr.map((e) => e.title));
}
main();
