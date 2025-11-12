<div class="sidebar sidebar-dark sidebar-fixed border-end" id="sidebar">
    <div class="sidebar-header border-bottom">
        <div class="sidebar-brand">
            <svg class="sidebar-brand-full" width="88" height="32" alt="CoreUI Logo">
                <use xlink:href="assets/brand/coreui.svg#full"></use>
            </svg>
            <svg class="sidebar-brand-narrow" width="32" height="32" alt="CoreUI Logo">
                <use xlink:href="assets/brand/coreui.svg#signet"></use>
            </svg>
        </div>
        <button class="btn-close d-lg-none" type="button" data-coreui-theme="dark" aria-label="Close"
            onclick="coreui.Sidebar.getInstance(document.querySelector(&quot;#sidebar&quot;)).toggle()"></button>
    </div>
    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
        <li class="nav-item">
            <a class="nav-link" wire:current.strict="font-bold" href="{{ route('admin.dashboard') }}">
                <svg class="nav-icon">
                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-speedometer"></use>
                </svg> Dashboard<span class="badge badge-sm bg-info ms-auto">NEW</span></a>
        </li>
        <li class="nav-title">User</li>
        <li class="nav-item">
            <a class="nav-link" wire:current.strict="font-bold" href="{{ route('admin.user') }}">
                <svg class="nav-icon">
                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-user"></use>
                </svg> User</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" wire:current.strict="font-bold" href="{{ route('admin.addresses') }}">
                <svg class="nav-icon">
                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-address-book"></use>
                </svg> Address</a>
        </li>
        <li class="nav-title">Product</li>
        <li class="nav-item">
            <a class="nav-link" wire:current.strict="font-bold" href="{{ route('admin.products') }}">
                <svg class="nav-icon">
                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-3d"></use>
                </svg> Product</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" wire:current.strict="font-bold" href="{{ route('admin.review') }}">
                <svg class="nav-icon">
                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-star"></use>
                </svg> Review</a>
        </li>

        <li class="nav-title">Blog</li>
        <li class="nav-item">
            <a class="nav-link" wire:current.strict="font-bold" href="{{ route('admin.blogs') }}">
                <svg class="nav-icon">
                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-align-left"></use>
                </svg> Blog</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" wire:current.strict="font-bold" href="{{ route('admin.comments') }}">
                <svg class="nav-icon">
                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-comment-bubble"></use>
                </svg> Comment</a>
        </li>
        <li class="nav-title">Order</li>
        <li class="nav-item">
            <a class="nav-link" wire:current.strict="font-bold" href="{{ route('admin.orders') }}">
                <svg class="nav-icon">
                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-notes"></use>
                </svg> Order</a>
        </li>
        <li class="nav-title">Noti</li>
        <li class="nav-item">
            <a class="nav-link" wire:current.strict="font-bold" href="{{ route('admin.mails') }}">
                <svg class="nav-icon">
                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-envelope-closed"></use>
                </svg> Mail</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" wire:current.strict="font-bold" href="{{ route('admin.notifications') }}">
                <svg class="nav-icon">
                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-bell"></use>
                </svg> Notification</a>
        </li>
        <li class="nav-title">Shared</li>
        <li class="nav-item">
            <a class="nav-link" wire:current.strict="font-bold" href="{{ route('admin.images') }}">
                <svg class="nav-icon">
                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-image"></use>
                </svg> Image</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" wire:current.strict="font-bold" href="{{ route('admin.categories') }}">
                <svg class="nav-icon">
                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-basket"></use>
                </svg> Category</a>
        </li>
    </ul>
    <div class="sidebar-footer border-top d-none d-md-flex">
        <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
    </div>
</div>
