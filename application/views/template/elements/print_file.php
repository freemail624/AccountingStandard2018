<div id="card"></div>

<script src="assets\js-master\zip.js-master\WebContent\zip.js"></script>
<script src="assets\js-master\zip.js-master\WebContent\zip-ext.js"></script>
<script src="assets\js-master\zip.js-master\WebContent\deflate.js"></script>
<script src="assets\js-master\JSPrintManager-master\scripts\JSPrintManager.js"></script>
<script src="assets\js-master\html2canvas.min.js"></script>

<script>
 
    //WebSocket settings
    JSPM.JSPrintManager.auto_reconnect = true;
    JSPM.JSPrintManager.start();
    JSPM.JSPrintManager.WS.onStatusChanged = function () {
        if (jspmWSStatus()) {
            //get client installed printers
            JSPM.JSPrintManager.getPrinters().then(function (myPrinters) {
                var options = '';
                for (var i = 0; i < myPrinters.length; i++) {
                    options += '<option>' + myPrinters[i] + '</option>';
                }
                // $('#installedPrinterName').html(options);
            });
        }
    };
 
    //Check JSPM WebSocket status
    function jspmWSStatus() {
        if (JSPM.JSPrintManager.websocket_status == JSPM.WSStatus.Open)
            return true;
        else if (JSPM.JSPrintManager.websocket_status == JSPM.WSStatus.Closed) {
            alert('JSPrintManager (JSPM) is not installed or not running! Download JSPM Client App from https://neodynamic.com/downloads/jspm');
            return false;
        }
        else if (JSPM.JSPrintManager.websocket_status == JSPM.WSStatus.Blocked) {
            alert('JSPM has blocked this website!');
            return false;
        }
    }
 
    //Do printing...
    function print(o) {
        if (jspmWSStatus()) {
            //generate an image of HTML content through html2canvas utility
            html2canvas(document.getElementById('card'), { scale: 5 }).then(function (canvas) {
 
                //Create a ClientPrintJob
                var cpj = new JSPM.ClientPrintJob();
                //Set Printer type (Refer to the help, there many of them!)
                cpj.clientPrinter = new JSPM.DefaultPrinter();

                //Set content to print... 
                var b64Prefix = "data:image/png;base64,";
                var imgBase64DataUri = canvas.toDataURL("image/png");
                var imgBase64Content = imgBase64DataUri.substring(b64Prefix.length, imgBase64DataUri.length);
 
                var myImageFile = new JSPM.PrintFile(imgBase64Content, JSPM.FileSourceType.Base64, 'myFileToPrint.png', 1);
                //add file to print job
                cpj.files.push(myImageFile);
 
                //Send print job to printer!
                cpj.sendToClient();
 
 
            });
        }
    }
 
</script>