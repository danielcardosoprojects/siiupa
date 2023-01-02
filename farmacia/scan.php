<script src="/siiupa/js/barcode/html5-qrcode.min.js" type="text/javascript"></script>
<div id="reader" width="400px" height="400px"></div>
<script>
var html5QrcodeScanner = new Html5QrcodeScanner(
    "reader", { fps: 10, qrbox: 250 });
        
function onScanSuccess(decodedText, decodedResult) {
    // Handle on success condition with the decoded text or result.
    console.log(`Scan result: ${decodedText}`, decodedResult);
	$("#resultado").html(decodedText);
        html5QrcodeScanner.clear();
		delete html5QrcodeScanner;
        $("#dialogScan").dialog("close");
        $("#resultado").attr("tabindex",-1).focus();
		html5QrcodeScanner.clear();
    // ...
    html5QrcodeScanner.clear();
    // ^ this will stop the scanner (video feed) and clear the scan area.
}

html5QrcodeScanner.render(onScanSuccess);

	
</script>