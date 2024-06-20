@extends('layout')
@section('title','Product Detail')

@section('style')
<link rel="stylesheet" href="{{ asset('/css/customOrder.css') }}"/>
@endsection

@section('content')
<div class="container hero-content">
    <div class="text-center">
        <h1 class="mb-1 mt-5 fw-bold">CUSTOM ORDER</h1>
    </div>

    <div class="mt-5">
        <div class="row">
            <div class="col-12">
                <div class="checkout-form mb-5">
                    @if($errors->any())
                        <div class="alert alert-danger" role="alert">
                            {{$errors->first()}}
                            <button  type="button" class="close float-end border-1 bg-danger text-light border-danger ms-auto px-2 rounded" data-bs-dismiss="alert">×</button>
                        </div>
                    @endif
                    @if(Session::has('message'))
                        <p class="alert alert-success">{{ Session::get('message') }}</p>
                    @endif
                    <form method="POST" action="/addCartCustom">
                        @csrf

                        <div class="form-group mb-3">
                            <h4 class="mb-3"><strong>Choose Size</strong></h4>
                            <div class="row size_deg mb-4">
                                <div class="col-6 col-md-2 mb-3">
                                    <div class="form-check ">
                                        <input class="form-check-input" type="radio" name="size" id="sizeSmall" value="Small 5 Stem"  checked required>
                                        <label class="form-check-label" for="sizeSmall">
                                            <img class="img-fluid mb-3" src="/asset/small.png" alt="small" />
                                            <h5>Small <br>5 stem</h5>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-6 col-md-2 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="size" id="sizeMedium" value="Medium 15 Stem" required>
                                        <label class="form-check-label" for="sizeMedium">
                                            <img class="img-fluid mb-3" src="/asset/medium.png" alt="medium" />
                                            <h5>Medium <br>15 stem</h5>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-6 col-md-2 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="size" id="sizeLarge" value="Large 30 Stem" required>
                                        <label class="form-check-label" for="sizeLarge">
                                            <img class="img-fluid mb-3" src="/asset/large.png" alt="large" />
                                            <h5>Large <br>30 stem</h5>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <h4 class="mb-3"><strong>Flower</strong></h4>
                            <div class="row flower mb-4">
                                <div class="col-6 col-md-2 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="flower[]" id="peachRose" value="Peach Rose" checked>
                                        <label class="form-check-label" for="peachRose">
                                            <img class="img-fluid" src="/asset/Flowers-01.png" alt="peachRose" />
                                        </label>
                                    </div>
                                </div>
                                <div class="col-6 col-md-2 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="flower[]" id="whiteRose" value="White Rose" >
                                        <label class="form-check-label" for="whiteRose">
                                            <img class="img-fluid" src="/asset/Flowers-02.png" alt="whiteRose" />
                                        </label>
                                    </div>
                                </div>
                                <div class="col-6 col-md-2 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="flower[]" id="pinkRose" value="Pink Rose" >
                                        <label class="form-check-label" for="pinkRose">
                                            <img class="img-fluid" src="/asset/Flowers-03.png" alt="pinkRose" />
                                        </label>
                                    </div>
                                </div>
                                <div class="col-6 col-md-2 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="flower[]" id="redRose" value="Red Rose" >
                                        <label class="form-check-label" for="redRose">
                                            <img class="img-fluid" src="/asset/Flowers-04.png" alt="redRose" />
                                        </label>
                                    </div>
                                </div>
                                <div class="col-6 col-md-2 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="flower[]" id="pinkCarnation" value="Pink Carnation" >
                                        <label class="form-check-label" for="pinkCarnation">
                                            <img class="img-fluid" src="/asset/Flowers-05.png" alt="pinkCarnation" />
                                        </label>
                                    </div>
                                </div>
                                <div class="col-6 col-md-2 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="flower[]" id="purpleCarnation" value="Purple Carnation" >
                                        <label class="form-check-label" for="purpleCarnation">
                                            <img class="img-fluid" src="/asset/Flowers-06.png" alt="purpleCarnation" />
                                        </label>
                                    </div>
                                </div>
                                <div class="col-6 col-md-2 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="flower[]" id="sunFlower" value="Sunflower" >
                                        <label class="form-check-label" for="sunFlower">
                                            <img class="img-fluid" src="/asset/Flowers-07.png" alt="sunFlower" />
                                        </label>
                                    </div>
                                </div>
                                <div class="col-6 col-md-2 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="flower[]" id="yellowPomPom" value="Yellow PomPom" >
                                        <label class="form-check-label" for="yellowPomPom">
                                            <img class="img-fluid" src="/asset/Flowers-08.png" alt="yellowPomPom" />
                                        </label>
                                    </div>
                                </div>
                                <div class="col-6 col-md-2 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="flower[]" id="whitePomPom" value="White PomPom" >
                                        <label class="form-check-label" for="whitePomPom">
                                            <img class="img-fluid" src="/asset/Flowers-09.png" alt="whitePomPom" />
                                        </label>
                                    </div>
                                </div>
                                <div class="col-6 col-md-2 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="flower[]" id="softPinkGompie" value="Soft Pink Gompie" >
                                        <label class="form-check-label" for="softPinkGompie">
                                            <img class="img-fluid" src="/asset/Flowers-10.png" alt="softPinkGompie" />
                                        </label>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <h4 class="mb-3"><strong>Fillers</strong></h4>
                        <div class="row mb-4">
                            <div class="col-6 col-md-2 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="fillers[]" id="caspea" value="Caspea">
                                    <label class="form-check-label" for="caspea">
                                        <img class="img-fluid" src="/asset/filler-1.png" alt="caspea" />
                                    </label>
                                </div>
                            </div>
                            <div class="col-6 col-md-2 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="fillers[]" id="whiteCarnationSpray" value="White Carnation Spray">
                                    <label class="form-check-label" for="whiteCarnationSpray">
                                        <img class="img-fluid" src="/asset/filler-2.png" alt="whiteCarnationSpray" />
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div id="flower-container">
                            <h4>Total Price: <span id="total-price"> 0</span></h4>
                        </div>

                        <h4 class="mb-3"><strong>Leaves</strong></h4>
                        <div class="row mb-4">
                            <div class="col-6 col-md-2 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="leaves" id="silverDollar" value="Silver Dollar" required checked>
                                    <label class="form-check-label" for="silverDollar">
                                        <img class="img-fluid" src="/asset/leaf-1.png" alt="silverDollar" />
                                    </label>
                                </div>
                            </div>
                            <div class="col-6 col-md-2 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="leaves" id="ruskus" value="Ruskus" required>
                                    <label class="form-check-label" for="ruskus">
                                        <img class="img-fluid" src="/asset/leaf-2.png" alt="ruskus" />
                                    </label>
                                </div>
                            </div>
                            <div class="col-6 col-md-2 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="leaves" id="populus" value="Populus" required>
                                    <label class="form-check-label" for="populus">
                                        <img class="img-fluid" src="/asset/leaf-3.png" alt="populus" />
                                    </label>
                                </div>
                            </div>
                            <div class="col-6 col-md-2 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="leaves" id="parvifolia" value="Parvifolia" required>
                                    <label class="form-check-label" for="parvifolia">
                                        <img class="img-fluid" src="/asset/leaf-4.png" alt="parvifolia" />
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <h4 class="mb-3"><strong>Choose Paper</strong></h4>
                            <div class="row">
                                <div class="col-6 col-md-2 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="color" id="brown" value="Brown" required checked>
                                        <label class="form-check-label" for="brown">
                                            <img class="img-fluid" src="/asset/paper-1.png" alt="brown" />
                                        </label>
                                    </div>
                                </div>
                                <div class="col-6 col-md-2 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="color" id="darkPink" value="Dark Pink" required>
                                        <label class="form-check-label" for="darkPink">
                                            <img class="img-fluid" src="/asset/paper-2.png" alt="darkPink" />
                                        </label>
                                    </div>
                                </div>
                                <div class="col-6 col-md-2 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="color" id="black" value="Black" required>
                                        <label class="form-check-label" for="black">
                                            <img class="img-fluid" src="/asset/paper-3.png" alt="black" />
                                        </label>
                                    </div>
                                </div>
                                <div class="col-6 col-md-2 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="color" id="creme" value="Creme" required>
                                        <label class="form-check-label" for="creme">
                                            <img class="img-fluid" src="/asset/paper-4.png" alt="creme" />
                                        </label>
                                    </div>
                                </div>
                                <div class="col-6 col-md-2 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="color" id="transparent" value="Transparent" required>
                                        <label class="form-check-label" for="transparent">
                                            <img class="img-fluid" src="/asset/paper-5.png" alt="transparent" />
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <h4 class="mb-3"><strong>Choose Ribbon</strong></h4>
                            <div class="row">
                                <div class="col-6 col-md-2 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="ribbon" id="ribbonblue" value="Blue" required checked>
                                        <label class="form-check-label" for="ribbonblue">
                                            <img class="img-fluid" src="/asset/ribbon-1.png" alt="ribbonblue" />
                                        </label>
                                    </div>
                                </div>
                                <div class="col-6 col-md-2 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="ribbon" id="ribbongreen" value="Green" required>
                                        <label class="form-check-label" for="ribbongreen">
                                            <img class="img-fluid" src="/asset/ribbon-2.png" alt="ribbongreen" />
                                        </label>
                                    </div>
                                </div>
                                <div class="col-6 col-md-2 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="ribbon" id="ribbondarkPink" value="Dark Pink" required>
                                        <label class="form-check-label" for="ribbondarkPink">
                                            <img class="img-fluid" src="/asset/ribbon-3.png" alt="ribbondarkPink" />
                                        </label>
                                    </div>
                                </div>
                                <div class="col-6 col-md-2 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="ribbon" id="ribbonbrown" value="Brown" required>
                                        <label class="form-check-label" for="ribbonbrown">
                                            <img class="img-fluid" src="/asset/ribbon-4.png" alt="ribbonbrown" />
                                        </label>
                                    </div>
                                </div>
                                <div class="col-6 col-md-2 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="ribbon" id="ribboncreme" value="Creme" required>
                                        <label class="form-check-label" for="ribboncreme">
                                            <img class="img-fluid" src="/asset/ribbon-5.png" alt="ribboncreme" />
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="total_price" id="hidden-total-price" value="0">
                        <input type="hidden" name="image_url" id="hidden-image-url" value="/asset/small.png">
                        <button type="submit" class="btn btn-primary">Add to Cart</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('script')
<script>

    const sizeImages = {
        'Small 5 Stem': '/asset/small.png',
        'Medium 15 Stem': '/asset/medium.png',
        'Large 30 Stem': '/asset/large.png'
    };

    // Get all size radio buttons
    const sizeRadios = document.querySelectorAll('input[name="size"]');

    // Function to update image based on selected size
    function updateImage() {
        const selectedSize = document.querySelector('input[name="size"]:checked').value;
        const imageURL = sizeImages[selectedSize];
        const imageElement = document.getElementById('sizeImage');
        if (imageElement) {
            imageElement.src = imageURL;
        }
        const hiddenImageInput = document.getElementById('hidden-image-url');
        if (hiddenImageInput) {
            hiddenImageInput.value = imageURL;
        }
    }

    // Add event listeners to size radio buttons
    sizeRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            updateImage();
            limitCheckboxSelection(3, 'flower'); // Add this line to re-validate after size change
        });
    });

    // Initial image update on page load
    updateImage();

    function limitCheckboxSelection(maxAllowed, checkboxGroup) {
    var checkboxes = document.getElementsByName(checkboxGroup +'[]');
    var checkedCount = 0;
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked) {
            checkedCount++;
        }
    }
    if (checkedCount > maxAllowed) {
        var alertMessage = document.createElement('div');
        alertMessage.classList.add('alert', 'alert-danger');

        var closeButton = document.createElement('button');
        closeButton.classList.add('close','float-end','border-1','bg-danger','text-light','border-danger' ,'ms-auto' ,'px-2' ,'rounded');
        closeButton.innerHTML = '&times;';
        closeButton.addEventListener('click', function() {
            alertMessage.parentNode.removeChild(alertMessage);
        });

        alertMessage.textContent = "You can only select a maximum of " + maxAllowed + " flowers.";
        alertMessage.appendChild(closeButton);


        var checkboxContainer = document.getElementById(checkboxGroup + '-container');


        var existingAlert = checkboxContainer.querySelector('.alert');
        if (existingAlert) {
            checkboxContainer.removeChild(existingAlert);
        }

        checkboxContainer.appendChild(alertMessage);
        return false;
    }
    return true;
}


function handleCheckboxChange(maxAllowed, checkboxGroup) {
    var checkboxes = document.getElementsByName(checkboxGroup+ '[]');
    for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].addEventListener('change', function() {
            if (!limitCheckboxSelection(maxAllowed, checkboxGroup)) {
                this.checked = false;
            }
        });
    }
}


handleCheckboxChange(3, 'flower');

document.addEventListener('DOMContentLoaded', function () {
        const flowerPrices = {
            "Peach Rose": 15000,
            "White Rose": 15000,
            "Pink Rose": 15000,
            "Red Rose": 10000,
            "Pink Carnation": 10000,
            "Purple Carnation": 10000,
            "Sunflower": 12000,
            "Yellow PomPom": 10000,
            "White PomPom": 10000,
            "Soft Pink Gompie": 15000
        };

        const fillerPrices = {
            "Small": {
                "Caspea": 10000,
                "White Carnation Spray": 15000
            },
            "Medium": {
                "Caspea": 25000,
                "White Carnation Spray": 30000
            },
            "Large": {
                "Caspea": 35000,
                "White Carnation Spray": 40000
            }
        };

        const fillerCheckboxes = document.querySelectorAll('input[name="fillers[]"]');
        const flowerCheckboxes = document.querySelectorAll('input[name="flower[]"]');
        const sizeRadios = document.querySelectorAll('input[name="size"]');
        const totalPriceElement = document.getElementById('total-price');
        const hiddenTotalPriceElement = document.getElementById('hidden-total-price');


        flowerCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updatePrice);
        });

        fillerCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updatePrice);
        });

        sizeRadios.forEach(radio => {
            radio.addEventListener('change', updatePrice);
        });

        function updatePrice() {
            const selectedSizeAndStem = document.querySelector('input[name="size"]:checked').value;
            const selectedSize = selectedSizeAndStem.split(" ")[0];
            const selectedFlowers = Array.from(document.querySelectorAll('input[name="flower[]"]:checked')).map(cb => cb.value);
            const selectedFillers = Array.from(document.querySelectorAll('input[name="fillers[]"]:checked')).map(cb => cb.value);

            let totalPrice = 0;
            if (selectedFlowers.length > 0) {
                if (selectedSize === 'Small') {
                    if (selectedFlowers.length === 1) {
                        totalPrice = 5 * flowerPrices[selectedFlowers[0]];
                    } else if (selectedFlowers.length === 2) {
                        totalPrice = 2 * flowerPrices[selectedFlowers[0]] + 3 * flowerPrices[selectedFlowers[1]];
                    } else if (selectedFlowers.length === 3) {
                        totalPrice = 2 * flowerPrices[selectedFlowers[0]] + 2 * flowerPrices[selectedFlowers[1]] + 1 * flowerPrices[selectedFlowers[2]];
                    }
                } else if (selectedSize === 'Medium') {
                    if (selectedFlowers.length === 1) {
                        totalPrice = 15 * flowerPrices[selectedFlowers[0]];
                    } else if (selectedFlowers.length === 2) {
                        totalPrice = 7.5 * flowerPrices[selectedFlowers[0]] + 7.5 * flowerPrices[selectedFlowers[1]];
                    } else if (selectedFlowers.length === 3) {
                        totalPrice = 5 * flowerPrices[selectedFlowers[0]] + 5 * flowerPrices[selectedFlowers[1]] + 5 * flowerPrices[selectedFlowers[2]];
                    }
                } else if (selectedSize === 'Large') {
                    if (selectedFlowers.length === 1) {
                        totalPrice = 30 * flowerPrices[selectedFlowers[0]];
                    } else if (selectedFlowers.length === 2) {
                        totalPrice = 15 * flowerPrices[selectedFlowers[0]] + 15 * flowerPrices[selectedFlowers[1]];
                    } else if (selectedFlowers.length === 3) {
                        totalPrice = 10 * flowerPrices[selectedFlowers[0]] + 10 * flowerPrices[selectedFlowers[1]] + 10 * flowerPrices[selectedFlowers[2]];
                    }
                }
            }

            selectedFillers.forEach(filler => {
                totalPrice += fillerPrices[selectedSize][filler];
            });

            totalPriceElement.textContent = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(totalPrice);
            hiddenTotalPriceElement.value = totalPrice;
        }
    });
</script>
@endsection
