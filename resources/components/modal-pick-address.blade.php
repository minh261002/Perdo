@push('styles')
    <style>
        .pac-container {
            z-index: 99999999 !important;
        }
    </style>
@endpush
<div class="modal modal-blur fade" id="modalPickAddress" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Chọn địa chỉ</h5>
                <button type="button" class="btn-close cancel-pick-address" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="" class="form-label">Chọn địa chỉ</label>
                    <input name="pickPlace" class="form-control" id="pickPlace" />
                </div>
                <div id="pickedAddress" class="mb-3">
                    <span><strong>
                            @lang('Địa chỉ đã chọn')
                        </strong></span>:
                    <span class="show-text"></span>
                </div>
                <div class="mb-3">
                    <label for="" class="control-label">
                        <strong>
                            @lang('Địa chỉ cụ thể')
                        </strong>
                        @lang('(Hãy nhập thêm địa chỉ bên dưới nếu địa chỉ đã chọn không đúng với địa chỉ của bạn đã chọn)')
                    </label>
                    <input name="pick_address_detail" class="form-control" id="pickAddressDetail"
                        :placeholder="trans('Tên thôn, thị xã, tên đường, tòa nhà, số nhà')" />
                </div>
                <div id="showMap" class="w-100" style="height: 400px"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link link-secondary me-auto cancel-pick-address"
                    data-bs-dismiss="modal">Huỷ</button>
                <button type="button" id="confirmPickAddress" class="btn btn-danger"
                    data-bs-dismiss="modal">@lang('oke')</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        var map;
        var marker;
        var autocomplete;

        function initMap() {
            map = new google.maps.Map(document.getElementById('showMap'), {
                center: {
                    lat: 10.762622,
                    lng: 106.660172
                },
                zoom: 12,
                gestureHandling: "cooperative"
            });

            marker = new google.maps.Marker({
                map: map,
                draggable: true
            });

            autocomplete = new google.maps.places.Autocomplete(document.getElementById('pickPlace'));
            autocomplete.bindTo('bounds', map);

            autocomplete.addListener('place_changed', function() {
                var place = autocomplete.getPlace();
                if (!place.geometry) {
                    console.error("Place not found:", place.name);
                    return;
                }

                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                    map.setZoom(17);
                }

                marker.setPosition(place.geometry.location);
                marker.setVisible(true);

                var address = '';
                if (place.address_components) {
                    address = [
                        (place.address_components[0] && place.address_components[0].short_name || ''),
                        (place.address_components[1] && place.address_components[1].short_name || ''),
                        (place.address_components[2] && place.address_components[2].short_name || '')
                    ].join(' ');
                }

                $('#pickedAddress .show-text').text(address);
            });

            marker.addListener('dragend', function() {
                geocodePosition(marker.getPosition());
            });

            function geocodePosition(pos) {
                var geocoder = new google.maps.Geocoder();
                geocoder.geocode({
                    latLng: pos
                }, function(responses) {
                    if (responses && responses.length > 0) {
                        marker.formatted_address = responses[0].formatted_address;
                        $('#pickedAddress .show-text').text(marker.formatted_address);
                    } else {
                        $('#pickedAddress .show-text').text('Cannot determine address at this location.');
                    }
                });
            }
        }
    </script>
@endpush
