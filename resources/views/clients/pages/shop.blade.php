@extends('layouts.pagef-layout')

@section('content')
    <!-- Searvices Start -->
    <div class="container-fluid px-0">
        <div class="row g-0">
            <div class="col-6 col-md-4 col-lg-2 border-start border-end wow fadeInUp" data-wow-delay="0.1s">
                <div class="p-4">
                    <div class="d-inline-flex align-items-center">
                        <i class="fa fa-sync-alt fa-2x text-primary"></i>
                        <div class="ms-4">
                            <h6 class="text-uppercase mb-2">Free Return</h6>
                            <p class="mb-0">30 days money back guarantee!</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-2 border-end wow fadeInUp" data-wow-delay="0.2s">
                <div class="p-4">
                    <div class="d-flex align-items-center">
                        <i class="fab fa-telegram-plane fa-2x text-primary"></i>
                        <div class="ms-4">
                            <h6 class="text-uppercase mb-2">Free Shipping</h6>
                            <p class="mb-0">Free shipping on all order</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-2 border-end wow fadeInUp" data-wow-delay="0.3s">
                <div class="p-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-life-ring fa-2x text-primary"></i>
                        <div class="ms-4">
                            <h6 class="text-uppercase mb-2">Support 24/7</h6>
                            <p class="mb-0">We support online 24 hrs a day</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-2 border-end wow fadeInUp" data-wow-delay="0.4s">
                <div class="p-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-credit-card fa-2x text-primary"></i>
                        <div class="ms-4">
                            <h6 class="text-uppercase mb-2">Receive Gift Card</h6>
                            <p class="mb-0">Recieve gift all over oder $50</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-2 border-end wow fadeInUp" data-wow-delay="0.5s">
                <div class="p-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-lock fa-2x text-primary"></i>
                        <div class="ms-4">
                            <h6 class="text-uppercase mb-2">Secure Payment</h6>
                            <p class="mb-0">We Value Your Security</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-2 border-end wow fadeInUp" data-wow-delay="0.6s">
                <div class="p-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-blog fa-2x text-primary"></i>
                        <div class="ms-4">
                            <h6 class="text-uppercase mb-2">Online Service</h6>
                            <p class="mb-0">Free return products in 30 days</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Searvices End -->


    <!-- Products Offer Start -->
    {{-- <div class="container-fluid bg-light py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.2s">
                    <a href="#"
                        class="d-flex align-items-center justify-content-between border bg-white rounded p-4">
                        <div>
                            <p class="text-muted mb-3">Find The Best Camera for You!</p>
                            <h3 class="text-primary">Smart Camera</h3>
                            <h1 class="display-3 text-secondary mb-0">40% <span class="text-primary fw-normal">Off</span>
                            </h1>
                        </div>
                        <img src="{{ asset('client/img/product-1.png') }}" class="img-fluid" alt="">
                    </a>
                </div>
                <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.3s">
                    <a href="#"
                        class="d-flex align-items-center justify-content-between border bg-white rounded p-4">
                        <div>
                            <p class="text-muted mb-3">Find The Best Whatches for You!</p>
                            <h3 class="text-primary">Smart Whatch</h3>
                            <h1 class="display-3 text-secondary mb-0">20% <span class="text-primary fw-normal">Off</span>
                            </h1>
                        </div>
                        <img src="{{ asset('client/img/product-2.png') }}" class="img-fluid" alt="">
                    </a>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- Products Offer End -->


    <!-- Shop Page Start -->
    <div class="container-fluid shop py-5">
        <div class="container py-5">
            <div class="row g-4">
                <div class="col-lg-3 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="product-categories mb-4">
                        <h4>Products Categories</h4>
                        <ul class="list-unstyled">
                            <li>
                                <div class="categories-item">
                                    <a href="#" class="text-dark"><i class="fas fa-apple-alt text-secondary me-2"></i>
                                        Accessories</a>
                                    <span>(3)</span>
                                </div>
                            </li>
                            <li>
                                <div class="categories-item">
                                    <a href="#" class="text-dark"><i class="fas fa-apple-alt text-secondary me-2"></i>
                                        Electronics & Computer</a>
                                    <span>(5)</span>
                                </div>
                            </li>
                            <li>
                                <div class="categories-item">
                                    <a href="#" class="text-dark"><i
                                            class="fas fa-apple-alt text-secondary me-2"></i>Laptops & Desktops</a>
                                    <span>(2)</span>
                                </div>
                            </li>
                            <li>
                                <div class="categories-item">
                                    <a href="#" class="text-dark"><i
                                            class="fas fa-apple-alt text-secondary me-2"></i>Mobiles & Tablets</a>
                                    <span>(8)</span>
                                </div>
                            </li>
                            <li>
                                <div class="categories-item">
                                    <a href="#" class="text-dark"><i
                                            class="fas fa-apple-alt text-secondary me-2"></i>SmartPhone & Smart TV</a>
                                    <span>(5)</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="price mb-4">
                        <h4 class="mb-2">Price</h4>
                        <input type="range" class="form-range w-100" id="rangeInput" name="rangeInput" min="0"
                            max="500" value="0" oninput="amount.value=rangeInput.value">
                        <output id="amount" name="amount" min-velue="0" max-value="500" for="rangeInput">0</output>
                        <div class=""></div>
                    </div>
                    <div class="product-color mb-3">
                        <h4>Select By Color</h4>
                        <ul class="list-unstyled">
                            <li>
                                <div class="product-color-item">
                                    <a href="#" class="text-dark"><i class="fas fa-apple-alt text-secondary me-2"></i>
                                        Gold</a>
                                    <span>(1)</span>
                                </div>
                            </li>
                            <li>
                                <div class="product-color-item">
                                    <a href="#" class="text-dark"><i
                                            class="fas fa-apple-alt text-secondary me-2"></i>
                                        Green</a>
                                    <span>(1)</span>
                                </div>
                            </li>
                            <li>
                                <div class="product-color-item">
                                    <a href="#" class="text-dark"><i
                                            class="fas fa-apple-alt text-secondary me-2"></i>
                                        White</a>
                                    <span>(1)</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="featured-product mb-4">
                        <h4 class="mb-3">Featured products</h4>
                        <div class="featured-product-item">
                            <div class="rounded me-4" style="width: 100px; height: 100px;">
                                <img src="{{ asset('client/img/product-3.png') }}" class="img-fluid rounded"
                                    alt="Image">
                            </div>
                            <div>
                                <h6 class="mb-2">SmartPhone</h6>
                                <div class="d-flex mb-2">
                                    <i class="fa fa-star text-secondary"></i>
                                    <i class="fa fa-star text-secondary"></i>
                                    <i class="fa fa-star text-secondary"></i>
                                    <i class="fa fa-star text-secondary"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                                <div class="d-flex mb-2">
                                    <h5 class="fw-bold me-2">2.99 $</h5>
                                    <h5 class="text-danger text-decoration-line-through">4.11 $</h5>
                                </div>
                            </div>
                        </div>
                        <div class="featured-product-item">
                            <div class="rounded me-4" style="width: 100px; height: 100px;">
                                <img src="{{ asset('client/img/product-4.png') }}" class="img-fluid rounded"
                                    alt="Image">
                            </div>
                            <div>
                                <h6 class="mb-2">Smart Camera</h6>
                                <div class="d-flex mb-2">
                                    <i class="fa fa-star text-secondary"></i>
                                    <i class="fa fa-star text-secondary"></i>
                                    <i class="fa fa-star text-secondary"></i>
                                    <i class="fa fa-star text-secondary"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                                <div class="d-flex mb-2">
                                    <h5 class="fw-bold me-2">2.99 $</h5>
                                    <h5 class="text-danger text-decoration-line-through">4.11 $</h5>
                                </div>
                            </div>
                        </div>
                        <div class="featured-product-item">
                            <div class="rounded me-4" style="width: 100px; height: 100px;">
                                <img src="{{ asset('client/img/product-5.png') }}" class="img-fluid rounded"
                                    alt="Image">
                            </div>
                            <div>
                                <h6 class="mb-2">Camera Leance</h6>
                                <div class="d-flex mb-2">
                                    <i class="fa fa-star text-secondary"></i>
                                    <i class="fa fa-star text-secondary"></i>
                                    <i class="fa fa-star text-secondary"></i>
                                    <i class="fa fa-star text-secondary"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                                <div class="d-flex mb-2">
                                    <h5 class="fw-bold me-2">2.99 $</h5>
                                    <h5 class="text-danger text-decoration-line-through">4.11 $</h5>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center my-4">
                            <a href="#" class="btn btn-primary px-4 py-3 rounded-pill w-100">Vew More</a>
                        </div>
                    </div>
                    <a href="#">
                        <div class="position-relative">
                            <img src="{{ asset('client/img/product-banner-2.jpg') }}" class="img-fluid w-100 rounded"
                                alt="Image">
                            <div class="text-center position-absolute d-flex flex-column align-items-center justify-content-center rounded p-4"
                                style="width: 100%; height: 100%; top: 0; right: 0; background: rgba(242, 139, 0, 0.3);">
                                <h5 class="display-6 text-primary">SALE</h5>
                                <h4 class="text-secondary">Get UP To 50% Off</h4>
                                <a href="#" class="btn btn-primary rounded-pill px-4">Shop Now</a>
                            </div>
                        </div>
                    </a>
                    <div class="product-tags py-4">
                        <h4 class="mb-3">PRODUCT TAGS</h4>
                        <div class="product-tags-items bg-light rounded p-3">
                            <a href="#" class="border rounded py-1 px-2 mb-2">New</a>
                            <a href="#" class="border rounded py-1 px-2 mb-2">brand</a>
                            <a href="#" class="border rounded py-1 px-2 mb-2">black</a>
                            <a href="#" class="border rounded py-1 px-2 mb-2">white</a>
                            <a href="#" class="border rounded py-1 px-2 mb-2">tablats</a>
                            <a href="#" class="border rounded py-1 px-2 mb-2">phone</a>
                            <a href="#" class="border rounded py-1 px-2 mb-2">camera</a>
                            <a href="#" class="border rounded py-1 px-2 mb-2">drone</a>
                            <a href="#" class="border rounded py-1 px-2 mb-2">talevision</a>
                            <a href="#" class="border rounded py-1 px-2 mb-2">slaes</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 wow fadeInUp" data-wow-delay="0.1s">
                    {{-- <div class="rounded mb-4 position-relative">
                        <img src="{{ asset('client/img/product-banner-3.jpg') }}" class="img-fluid rounded w-100" style="height: 250px;"
                            alt="Image">
                        <div class="position-absolute rounded d-flex flex-column align-items-center justify-content-center text-center"
                            style="width: 100%; height: 250px; top: 0; left: 0; background: rgba(242, 139, 0, 0.3);">
                            <h4 class="display-5 text-primary">SALE</h4>
                            <h3 class="display-4 text-white mb-4">Get UP To 50% Off</h3>
                            <a href="#" class="btn btn-primary rounded-pill">Shop Now</a>
                        </div>
                    </div> --}}
                    <div class="row g-4 pb-4">
                        <div class="col-xl-9">
                            <div class="input-group w-100 mx-auto d-flex">
                                <input type="search" class="form-control p-3" placeholder="keywords"
                                    aria-describedby="search-icon-1">
                                <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                            </div>
                        </div>
                        <div class="col-xl-3 text-end">
                            <div class="bg-light ps-3 py-3 rounded d-flex justify-content-between">
                                <label for="electronics">Sort By:</label>
                                <select id="electronics" name="electronicslist"
                                    class="border-0 form-select-sm bg-light me-3" form="electronicsform">
                                    <option value="volvo">Default Sorting</option>
                                    <option value="volv">Nothing</option>
                                    <option value="sab">Popularity</option>
                                    <option value="saab">Newness</option>
                                    <option value="opel">Average Rating</option>
                                    <option value="audio">Low to high</option>
                                    <option value="audi">High to low</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div id="tab-5" class="tab-pane fade show p-0 active">
                            <div class="row g-4 product">

                            <div class="row g-4" id="product-list"></div>

                            <div class="col-12 wow fadeInUp" data-wow-delay="0.1s">
                                <div id="pagination" class="pagination d-flex justify-content-center mt-5"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Shop Page End -->

    <!-- Product Banner Start -->
    <div class="container-fluid py-5">
        <div class="container pb-5">
            <div class="row g-4">
                <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.1s">
                    <a href="#">
                        <div class="bg-primary rounded position-relative">
                            <img src="{{ asset('client/img/product-banner.jpg') }}" class="img-fluid w-100 rounded"
                                alt="">
                            <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center rounded p-4"
                                style="background: rgba(255, 255, 255, 0.5);">
                                <h3 class="display-5 text-primary">EOS Rebel <br> <span>T7i Kit</span></h3>
                                <p class="fs-4 text-muted">$899.99</p>
                                <a href="#" class="btn btn-primary rounded-pill align-self-start py-2 px-4">Shop
                                    Now</a>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.2s">
                    <a href="#">
                        <div class="text-center bg-primary rounded position-relative">
                            <img src="{{ asset('client/img/product-banner-2.jpg') }}" class="img-fluid w-100"
                                alt="">
                            <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center rounded p-4"
                                style="background: rgba(242, 139, 0, 0.5);">
                                <h2 class="display-2 text-secondary">SALE</h2>
                                <h4 class="display-5 text-white mb-4">Get UP To 50% Off</h4>
                                <a href="#" class="btn btn-secondary rounded-pill align-self-center py-2 px-4">Shop
                                    Now</a>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Product Banner End -->
@endsection

@push('scripts')
    <script>
        // Cấu hình API
        const API_URL = 'http://127.0.0.1:8000/api/products?search=&filter[status]=&perPage=';

        // Hàm load và render products
        async function loadProducts(page = 1) {
            try {
                // Hiển thị loading
                const productContainer = document.querySelector('.row.g-4.product');
                productContainer.innerHTML =
                    '<div class="col-12 text-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>';

                // Lấy token từ localStorage
                // const token = localStorage.getItem("jwt_token");

                // Fetch dữ liệu với JWT token
                const res = await fetch(`${API_URL}`, {
                    headers: {
                        "Accept": "application/json",
                        "Authorization": `Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYXBpL2xvZ2luIiwiaWF0IjoxNzY1MTgzNDgyLCJleHAiOjE3NjUxODcwODIsIm5iZiI6MTc2NTE4MzQ4MiwianRpIjoicE5QV0NFbzVFYkFTbE1KMCIsInN1YiI6IjU2IiwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9._kR9d4R5qu_xKjVAbA9YZKiRDkxh6W2JqAyEYpjCet4`
                    }
                });

                // Kiểm tra nếu API trả về HTML (lỗi hoặc chưa đăng nhập)
                if (res.headers.get("content-type").includes("text/html")) {
                    const html = await res.text();
                    console.error("API returned HTML:", html);

                    productContainer.innerHTML = `
                <div class="col-12 text-center py-5">
                    <div class="alert alert-warning" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        API lỗi hoặc chưa đăng nhập.
                    </div>
                </div>
            `;
                    return;
                }

                // Kiểm tra response status
                if (!res.ok) {
                    throw new Error(`HTTP error! status: ${res.status}`);
                }

                const json = await res.json();
                // Render products và pagination
                renderProducts(json.data);
                console.log(json.data);
                renderPagination(json.meta);

                // QUAN TRỌNG: Khởi tạo lại WOW.js sau khi render
                setTimeout(() => {
                    initWowAnimation();
                }, 100);

            } catch (err) {
                console.error(err);

                // Hiển thị lỗi cho user
                const productContainer = document.querySelector('.row.g-4.product');
                productContainer.innerHTML = `
                    <div class="col-12 text-center py-5">
                        <div class="alert alert-danger" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Không thể tải sản phẩm. Vui lòng thử lại sau.
                        </div>
                        <button class="btn btn-primary" onclick="loadProducts()">
                            <i class="fas fa-redo me-2"></i>Thử lại
                        </button>
                    </div>
                `;
            }
        }



        // Hàm render products
        function renderProducts(products) {
            const productContainer = document.querySelector('.row.g-4.product');

            // Kiểm tra nếu không có products
            if (!products || products.length === 0) {
                productContainer.innerHTML = `
                    <div class="col-12 text-center py-5">
                        <p class="text-muted">Không có sản phẩm nào.</p>
                    </div>
                `;
                return;
            }

            let html = '';

            products.forEach((product, index) => {
                const delay = (index % 3) * 0.1 + 0.1; // Delay cho mỗi item

                const image = product.images?.length ?
                    `/storage/${product.images[0].url}` :
                    "/client/img/no-image.png";

                const categoryNames = formatCategories(product.categories, 2);

                html += `
                    <div class="col-lg-4">
                        <div class="product-item rounded wow fadeInUp" data-wow-delay="${delay}s">
                            <div class="product-item-inner border rounded">
                                <div class="product-item-inner-item">
                                    <img src="${image}"
                                        class="img-fluid w-100 rounded-top"
                                        alt="${product.name}"
                                        onerror="this.src='client/img/product-default.png'">
                                    <div class="product-details">
                                        <a href="#"><i class="fa fa-eye fa-1x"></i></a>
                                    </div>
                                </div>
                                <div class="rounded-bottom p-3">
                                    <span class="product-price">${product.price}</span>
                                    <a href="#" class="d-block h4" style="
                                            margin-bottom: unset;
                                        ">${product.name}</a>
                                    <span>${renderStars(product.reviews.rating)}(${product.reviews.num_rate})</span>

                                    <span href="#" class="product-category d-inline-block mb-2 mt-2">${categoryNames || 'Category'}</span>
                                </div>
                            </div>
                            <div class="product-item-add border border-top-0 rounded-bottom p-4 pt-0 d-flex align-items-center justify-content-between">
                                <!-- Nút Add To Cart -->
                                <button href="#" class="btn-add-cart border-secondary rounded-pill py-2 px-4 mb-0"
                                onclick="addToCart(${product.id}); return false;">
                                    <i class="fas fa-shopping-cart me-2"></i> Add To Cart
                                </button>

                                <!-- Trạng thái hàng -->
                                <span class="${product.stock > 0 ? 'text-success' : 'text-danger'} text-truncate">
                                    ${product.stock > 0 ? `Stock: ${product.stock}` : 'Out of Stock'}
                                </span>
                            </div>
                        </div>
                    </div>
                `;
            });

            productContainer.innerHTML = html;
        }

        // Hàm render pagination từ Laravel meta
        function renderPagination(meta) {
            if (!meta) return;

            const productContainer = document.querySelector('.row.g-4.product');

            let paginationHTML = `
        <div class="col-12 wow fadeInUp" data-wow-delay="0.1s">
            <div class="pagination d-flex justify-content-center mt-5">
    `;

            // Previous button
            if (meta.current_page > 1) {
                paginationHTML += `<a href="#" class="rounded" data-page="${meta.current_page - 1}">&laquo;</a>`;
            } else {
                paginationHTML +=
                    `<a href="#" class="rounded disabled" style="pointer-events: none; opacity: 0.5;">&laquo;</a>`;
            }

            // Page numbers
            const totalPages = meta.last_page;
            const currentPage = meta.current_page;

            // Logic hiển thị page numbers (max 7 pages)
            let startPage = Math.max(1, currentPage - 3);
            let endPage = Math.min(totalPages, currentPage + 3);

            if (currentPage <= 3) {
                endPage = Math.min(7, totalPages);
            }

            if (currentPage > totalPages - 3) {
                startPage = Math.max(1, totalPages - 6);
            }

            for (let i = startPage; i <= endPage; i++) {
                const activeClass = i === currentPage ? 'active' : '';
                paginationHTML += `<a href="#" class="rounded ${activeClass}" data-page="${i}">${i}</a>`;
            }

            // Next button
            if (meta.current_page < meta.last_page) {
                paginationHTML += `<a href="#" class="rounded" data-page="${meta.current_page + 1}">&raquo;</a>`;
            } else {
                paginationHTML +=
                    `<a href="#" class="rounded disabled" style="pointer-events: none; opacity: 0.5;">&raquo;</a>`;
            }

            paginationHTML += `
            </div>
        </div>
    `;

            productContainer.innerHTML += paginationHTML;
        }

        // Hàm render stars
        function renderStars(rating) {
            let stars = '';
            for (let i = 1; i <= 5; i++) {
                if (i <= Math.floor(rating)) {
                    stars += `<i class="fas fa-star text-primary"></i>`;
                } else if (i === Math.ceil(rating) && rating % 1 !== 0) {
                    stars += `<i class="fas fa-star-half-alt text-primary"></i>`;
                } else {
                    stars += `<i class="far fa-star text-primary"></i>`;
                }
            }
            return stars;
        }

        function formatCategories(categories, maxDisplay = 2) {
            if (!categories || categories.length === 0) return "Uncategorized";

            const displayed = categories.slice(0, maxDisplay).map(c => c.name).join(", ");
            const remaining = categories.length - maxDisplay;

            return remaining > 0 ? `${displayed} +${remaining}` : displayed;
        }

        // Hàm khởi tạo lại WOW.js
        function initWowAnimation() {
            // Reset các class wow đã được animate
            const wowElements = document.querySelectorAll('.wow');
            wowElements.forEach(el => {
                el.classList.remove('animated');
                el.style.visibility = 'hidden';
                el.style.animationName = 'none';
            });

            // Khởi tạo lại WOW
            if (typeof WOW !== 'undefined') {
                const wow = new WOW({
                    boxClass: 'wow',
                    animateClass: 'animated',
                    offset: 0,
                    mobile: true,
                    live: true,
                    scrollContainer: null
                });
                wow.init();
            }
        }

        // Hàm add to cart (placeholder)
        function addToCart(productId) {
            console.log('Add to cart:', productId);
            // Implement logic add to cart của bạn ở đây
            alert('Đã thêm sản phẩm vào giỏ hàng!');
        }

        // Gọi hàm khi trang load
        document.addEventListener('DOMContentLoaded', function() {
            // Load products lần đầu
            loadProducts(1);

            // Xử lý pagination click
            document.addEventListener('click', function(e) {
                const paginationLink = e.target.closest('.pagination a:not(.disabled)');
                if (paginationLink) {
                    e.preventDefault();
                    const page = parseInt(paginationLink.dataset.page);

                    if (!isNaN(page)) {
                        loadProducts(page);

                        // Scroll to top
                        window.scrollTo({
                            top: 0,
                            behavior: 'smooth'
                        });
                    }
                }
            });
        });
    </script>
@endpush
