document.addEventListener('DOMContentLoaded', function() {
    // Get the modal
    const modal = document.getElementById('qrModal');
    // Get the <span> element that closes the modal
    const closeBtn = document.querySelector('#qrModal .close');
    
    // When the user clicks on <span> (x), close the modal
    closeBtn.onclick = function() {
        modal.style.display = "none";
    }
    
    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    
    // Add click event to all QR code buttons
    const qrButtons = document.querySelectorAll('.qr-code-btn');
    qrButtons.forEach(button => {
        button.addEventListener('click', function() {
            const articleId = this.getAttribute('data-article-id');
            // Show loading state
            document.getElementById('qrCodeImage').src = "data:image/gif;base64,R0lGODlhEAAQAPIAAP///wAAAMLCwkJCQgAAAGJiYoKCgpKSkiH/C05FVFNDQVBFMi4wAwEAAAAh/hpDcmVhdGVkIHdpdGggYWpheGxvYWQuaW5mbwAh+QQJCgAAACwAAAAAEAAQAAADMwi63P4wyklrE2MIOggZnAdOmGYJRbExwroUmcG2LmDEwnHQLVsYOd2mBzkYDAdKa+dIAAAh+QQJCgAAACwAAAAAEAAQAAADNAi63P5OjCEgG4QMu7DmikRxQlFUYDEZIGBMRVsaqHwctXXf7WEYB4Ag1xjihkMZsiUkKhIAIfkECQoAAAAsAAAAABAAEAAAAzYIujIjK8pByJDMlFYvBoVjHA70GU7xSUJhmKtwHPAKzLO9HMaoKwJZ7Rf8AYPDDzKpZBqfvwQAIfkECQoAAAAsAAAAABAAEAAAAzMIumIlK8oyhpHsnFZfhYumCYUhDAQxRIdhHBGqRoKw0R8DYlJd8z0fMDgsGo/IpHI5TAAAIfkECQoAAAAsAAAAABAAEAAAAzIIunInK0rnZBTwGPNMgQwmdsNgXGJUlIWEuR5oWUIpz8pAEAMe6TwfwyYsGo/IpFKSAAAh+QQJCgAAACwAAAAAEAAQAAADMwi6IMKQORfjdOe82p4wGccc4CEuQradylesojEMBgsUc2G7sDX3lQGBMLAJibufbSlKAAAh+QQJCgAAACwAAAAAEAAQAAADMgi63P7wCRHZnFVdmgHu2nFwlWCI3WGc3TSWhUFGxTAUkGCbtgENBMJAEJsxgMLWzpEAACH5BAkKAAAALAAAAAAQABAAAAMyCLrc/jDKSatlQtScKdceCAjDII7HcQ4EMTCpyrCuUBjCYRgHVtqlAiB1YhiCnlsRkAAAOwAAAAAAAAAAAA==";
            
            // Make AJAX request to get QR code
            fetch(`/articles/qrcode/${articleId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('qrCodeImage').src = data.qrCode;
                    modal.style.display = "block";
                })
                .catch(error => console.error('Error:', error));
        });
    });

    // Get the modal
    const uploadModal = document.getElementById('qrUploadModal');
    
    // Get the <span> element that closes the modal
    const uploadCloseBtn = document.querySelector('#qrUploadModal .close');
    
    // Get the QR upload button
    const qrUploadBtn = document.getElementById('qr-upload-btn');
    
    // When the user clicks on the QR upload button
    if(qrUploadBtn) {
        qrUploadBtn.addEventListener('click', function() {
            uploadModal.style.display = "block";
        });
    }
    
    // When the user clicks on <span> (x), close the modal
    if(uploadCloseBtn) {
        uploadCloseBtn.onclick = function() {
            uploadModal.style.display = "none";
        }
    }
    
    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == uploadModal) {
            uploadModal.style.display = "none";
        }
    }
    
    // Handle form submission with AJAX
    const qrUploadForm = document.getElementById('qrUploadForm');
    if(qrUploadForm) {
        qrUploadForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const resultDiv = document.getElementById('qrUploadResult');
            
            // Show loading indicator
            resultDiv.innerHTML = '<p>Procesando...</p>';
            
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if(response.redirected) {
                    // If we got redirected, follow the redirect
                    window.location.href = response.url;
                    return null;
                }
                return response.json();
            })
            .then(data => {
                if(data) {
                    if(data.success) {
                        resultDiv.innerHTML = `<p>Contenido del QR: <strong>${data.result}</strong></p>`;
                        // Si es una URL, añadir un enlace
                        if(data.result.startsWith('http')) {
                            resultDiv.innerHTML += `<p><a href="${data.result}" target="_blank">Abrir enlace</a></p>`;
                        }
                    } else {
                        resultDiv.innerHTML = `<p class="text-danger">${data.message}</p>`;
                    }
                }
            })
            .catch(error => {
                resultDiv.innerHTML = `<p class="text-danger">Error: ${error.message}</p>`;
                console.error('Error:', error);
            });
        });
    }
});