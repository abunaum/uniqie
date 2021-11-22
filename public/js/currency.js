function convertToRupiah(objek) {
  separator = ",";
  angka = objek.value;
  a = angka.replace(/^0+/, '');
  b = a.replace(/[^\d]/g,"");
  c = "";
  panjang = b.length; 
  j = 0; 
  for (i = panjang; i > 0; i--) {
    j = j + 1;
    if (((j % 3) == 1) && (j != 1)) {
      c = b.substr(i-1,1) + separator + c;
    } else {
      c = b.substr(i-1,1) + c;
    }
  }
  objek.value = c;

}       
