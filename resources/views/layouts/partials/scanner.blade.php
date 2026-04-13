<!-- QR Scanner Modal Shared Component -->
<div id="scannerModal" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-aviation-900/80 backdrop-blur-md hidden">
    <div class="bg-white rounded-3xl w-full max-w-lg overflow-hidden shadow-2xl">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <div class="flex items-center gap-3">
                <i data-lucide="scan-face" class="w-5 h-5 text-aviation-900"></i>
                <h3 class="font-black text-xs uppercase tracking-widest text-aviation-900">Equipment QR Identification</h3>
            </div>
            <button onclick="closeScanner()" class="text-slate-400 hover:text-rose-500 transition-colors">
                <i data-lucide="x-circle" class="w-6 h-6"></i>
            </button>
        </div>
        <div class="p-8">
            <div id="reader" class="rounded-2xl overflow-hidden border-2 border-dashed border-slate-200"></div>
            <div class="mt-6 text-center">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Instructions</p>
                <p class="text-xs text-slate-600 font-semibold italic">Align the equipment QR code within the frame for automatic detection.</p>
            </div>
        </div>
    </div>
</div>

<script>
    let html5QrCode;

    function openScanner() {
        document.getElementById('scannerModal').classList.remove('hidden');
        html5QrCode = new Html5Qrcode("reader");
        const config = { fps: 10, qrbox: { width: 250, height: 250 } };

        html5QrCode.start(
            { facingMode: "environment" }, 
            config, 
            onScanSuccess
        ).catch(err => {
            console.error(err);
            alert("Gagal mengakses kamera. Pastikan memberikan izin kamera.");
            closeScanner();
        });
    }

    function closeScanner() {
        document.getElementById('scannerModal').classList.add('hidden');
        if (html5QrCode) {
            html5QrCode.stop().then(() => {
                html5QrCode.clear();
            }).catch(err => console.error(err));
        }
    }

    function onScanSuccess(decodedText, decodedResult) {
        let targetUrl = "";
        
        if (decodedText.startsWith("http")) {
            targetUrl = decodedText;
        } 
        else if (decodedText.startsWith("/master-data/")) {
            targetUrl = decodedText;
        }
        else if (decodedText.startsWith("KD")) {
            targetUrl = `/master-data/${decodedText}`;
        } 
        else {
            alert("QR Code tidak valid atau bukan ID Peralatan MONITA.");
            return;
        }
        
        closeScanner();
        window.location.href = targetUrl;
    }
</script>
