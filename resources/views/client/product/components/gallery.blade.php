<div class="d-flex flex-column gap-3">
    <!-- Ảnh lớn -->
    <img src="{{ asset($product->image) }}" id="largeImage" class="w-100 h-100 border rounded-2" style="max-height: 750px;">

    <div class="gallery-wrapper">
        <button class="gallery-btn left" onclick="changeImageByIndex(-1)">❮</button>
        <div class="gallery-container" id="galleryContainer">
            @foreach (json_decode($product->gallery) as $index => $img)
                <img src="{{ asset($img) }}" class="border rounded-2 object-cover gallery-image"
                    onclick="changeImageByClick({{ $index }})" data-index="{{ $index }}">
            @endforeach
        </div>
        <button class="gallery-btn right" onclick="changeImageByIndex(1)">❯</button>
    </div>
</div>
@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let currentIndex = 0;
            const images = @json(json_decode($product->gallery));
            const largeImage = document.getElementById('largeImage');
            const galleryContainer = document.getElementById('galleryContainer');
            const galleryImages = document.querySelectorAll('.gallery-image');
            const step = 100;

            function changeImageByIndex(direction) {
                currentIndex += direction;

                if (currentIndex < 0) {
                    currentIndex = images.length - 1;
                } else if (currentIndex >= images.length) {
                    currentIndex = 0;
                }

                updateImage();
            }

            function changeImageByClick(index) {
                currentIndex = index;
                updateImage();
            }

            function updateImage() {
                largeImage.src = images[currentIndex];

                galleryImages.forEach((image, index) => {
                    if (index === currentIndex) {
                        image.classList.add('border-primary');
                    } else {
                        image.classList.remove('border-primary');
                    }
                });
                const selectedImage = galleryImages[currentIndex];
                if (selectedImage) {
                    const containerRect = galleryContainer.getBoundingClientRect();
                    const imageRect = selectedImage.getBoundingClientRect();

                    if (imageRect.left < containerRect.left || imageRect.right > containerRect.right) {
                        galleryContainer.scrollLeft = selectedImage.offsetLeft - containerRect.left;
                    }
                }
            }

            window.changeImageByIndex = changeImageByIndex;
            window.changeImageByClick = changeImageByClick;
        });
    </script>
@endpush
