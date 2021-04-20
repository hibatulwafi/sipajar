function simulasi()
{
    var awal = parseInt(document.getElementById("awal").value);
    var akhir = parseInt(document.getElementById("akhir").value);
    var npa = parseInt(document.getElementById("npa").value);
    var tarif = parseInt(document.getElementById("tarif").value);
    var hasil = document.getElementById("hasil");
    var total;

if(isNaN(awal) || isNaN(akhir)){
    alert('isi form dengan angka!')
}else{
    total = (akhir-awal)*npa*(tarif/100);
}
	
var	number_string = total.toString(),
	sisa 	= number_string.length % 3,
	rupiah 	= number_string.substr(0, sisa),
	ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
		
if (ribuan) {
	separator = sisa ? '.' : '';
	rupiah += separator + ribuan.join('.');
}
hasil.value =	rupiah;

}

