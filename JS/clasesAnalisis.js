/*analisis:
--Esta clase evalua las cadenas de texto para evitar injections a mysql*/
export class analisis {
 constructor(){
   this.caracter = Array(
      ",",
      "*",
      ";",
      "&",
      "'",
      '"',
      "%",
      "/",
      "|",
      "#",
      "!",
      ")",
      "}",
      "]",
      "`"
    );
  }
  
 analisisCampo(frase) {
    let text="";
    let fraseAnalisis = frase.split("");
    for (let i in fraseAnalisis) {
      let word = fraseAnalisis[i];
      for (let j of this.caracter) {
        if (j == word) {
          word=word.charCodeAt();
          word=word.toString(8);
        }
      }
      text=text+word; 
    }
    return text;
  }
  pintarCampos(frase){
    let text="";
    let fraseAnalisis = frase.split("");
    for (let i in fraseAnalisis) {
      let word = fraseAnalisis[i];
      for (let j of this.caracter) {
        if (j == word) {
          word=word.toString(10);
          word=String.fromCharCode(word);
        }
      }
      text=text+word; 
    }
    return text;
  }
  }
}
