<div id="qrUploadModal" class="modal" style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.4);">
    <div class="modal-content" style="background-color: #fefefe; margin: 15% auto; padding: 20px; border: 1px solid #888; width: 350px; text-align: center;">
        <span class="close" style="color: #aaa; float: right; font-size: 28px; font-weight: bold; cursor: pointer;">&times;</span>
        <h2>Leer código QR</h2>
        <form id="qrUploadForm" action="{{ route('articles.read-qrcode') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="qrFile">Selecciona una imagen con código QR:</label>
                <input type="file" name="qrFile" id="qrFile" accept="image/*" class="form-control">
            </div>
            <div class="form-group mt-3">
                <button type="submit" class="btn btn-primary">Leer QR</button>
            </div>
        </form>
        <div id="qrUploadResult" class="mt-3"></div>
    </div>
</div>