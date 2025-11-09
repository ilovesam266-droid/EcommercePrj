<div>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <form id="variantForm" wire:submit.prevent="createProductVariant">
        <div class="mb-3">
            <label for="variantName" class="form-label">Name Variant<span class="text-danger">*</span></label>
            <input type="text" class="form-control  @error('variant_size') is-invalid @enderror" id="variantName"
                placeholder="VD: Đỏ, Size M, 256GB" wire:model="variant_size">
            @error('variant_size')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="sku" class="form-label">Sku</label>
            <input type="text" class="form-control  @error('sku') is-invalid @enderror" id="sku"
                placeholder="" wire:model="sku">
            @error('sku')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="variantPrice" class="form-label">Price<span class="text-danger">*</span></label>
            <input type="number" class="form-control  @error('price') is-invalid @enderror" id="variantPrice"
                placeholder="Enter price" min="0" wire:model="price">
            @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="variantTotalSold" class="form-label">Total sold<span class="text-danger">*</span></label>
            <input type="number" class="form-control  @error('total_sold') is-invalid @enderror" id="variantTotalSold"
                placeholder="Enter total sold" min="0" wire:model="total_sold">
            @error('total_sold')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="variantStock" class="form-label">Stock<span class="text-danger">*</span></label>
            <input type="number" class="form-control  @error('stock') is-invalid @enderror" id="variantStock"
                placeholder="Enter stock" min="0" wire:model="stock">
            @error('stock')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary-custom" id="addVariantBtn">Add product variant</button>
    </form>
</div>
