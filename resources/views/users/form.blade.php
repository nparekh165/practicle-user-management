<div class="row mb-3">
    <div class="col">
        <label>First Name *</label>
        <input type="text" name="first_name" value="{{ old('first_name', $user->first_name ?? '') }}" class="form-control" required>
    </div>
    <div class="col">
        <label>Last Name</label>
        <input type="text" name="last_name" value="{{ old('last_name', $user->last_name ?? '') }}" class="form-control">
    </div>
</div>

<div class="row mb-3">
    <div class="col">
        <label>Date of Birth *</label>
        <input type="date" name="dob" value="{{ old('dob', isset($user) ? \Carbon\Carbon::parse($user->dob)->format('Y-m-d') : '') }}" class="form-control" required>
    </div>
    <div class="col">
        <label>Gender *</label>
        <select name="gender" class="form-control" required>
            <option value="">-- Select --</option>
            @foreach(['Male', 'Female', 'Other'] as $g)
                <option value="{{ $g }}" @selected(old('gender', $user->gender ?? '') === $g)>{{ $g }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="row mb-3">
    <div class="col">
        <label>Mobile</label>
        <input type="text" name="mobile" value="{{ old('mobile', $user->mobile ?? '') }}" class="form-control">
    </div>
</div>

<hr>
<h5>Addresses</h5>
<div id="address-wrapper">
    @php $addresses = old('addresses', $user->addresses ?? [null]); @endphp

    @foreach($addresses as $i => $address)
    <div class="border p-3 mb-3">
        <div class="row mb-2">
            <div class="col">
                <label>Address Type *</label>
                <select name="addresses[{{ $i }}][address_type]" class="form-control" required>
                    @foreach(['home', 'work', 'office'] as $type)
                        <option value="{{ $type }}" @selected(($address['address_type'] ?? $address->address_type ?? '') === $type)>
                            {{ ucfirst($type) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col">
                <label>Primary *</label>
                <select name="addresses[{{ $i }}][primary]" class="form-control" required>
                    <option value="No" @selected(($address['primary'] ?? $address->primary ?? '') === 'No')>No</option>
                    <option value="Yes" @selected(($address['primary'] ?? $address->primary ?? '') === 'Yes')>Yes</option>
                </select>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col">
                <label>Door No / Street</label>
                <input type="text" name="addresses[{{ $i }}][door_street]" class="form-control"
                       value="{{ $address['door_street'] ?? $address->door_street ?? '' }}">
            </div>
            <div class="col">
                <label>Landmark</label>
                <input type="text" name="addresses[{{ $i }}][landmark]" class="form-control"
                       value="{{ $address['landmark'] ?? $address->landmark ?? '' }}">
            </div>
        </div>

        <div class="row mb-2">
            <div class="col">
                <label>City *</label>
                <input type="text" name="addresses[{{ $i }}][city]" class="form-control"
                       value="{{ $address['city'] ?? $address->city ?? '' }}" required>
            </div>
            <div class="col">
                <label>State *</label>
                <input type="text" name="addresses[{{ $i }}][state]" class="form-control"
                       value="{{ $address['state'] ?? $address->state ?? '' }}" required>
            </div>
            <div class="col">
                <label>Country *</label>
                <input type="text" name="addresses[{{ $i }}][country]" class="form-control"
                       value="{{ $address['country'] ?? $address->country ?? '' }}" required>
            </div>
        </div>
    </div>
    @endforeach
</div>

<button type="button" class="btn btn-outline-secondary mb-3" onclick="addAddress()">+ Add Address</button>

@push('scripts')
<script>
let addressIndex = {{ count($addresses) }};
function addAddress() {
    const wrapper = document.getElementById('address-wrapper');
    const html = `
    <div class="border p-3 mb-3">
        <div class="row mb-2">
            <div class="col">
                <label>Address Type *</label>
                <select name="addresses[${addressIndex}][address_type]" class="form-control" required>
                    <option value="home">Home</option>
                    <option value="work">Work</option>
                    <option value="office">Office</option>
                </select>
            </div>
            <div class="col">
                <label>Primary *</label>
                <select name="addresses[${addressIndex}][primary]" class="form-control" required>
                    <option value="No">No</option>
                    <option value="Yes">Yes</option>
                </select>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col">
                <label>Door No / Street</label>
                <input type="text" name="addresses[${addressIndex}][door_street]" class="form-control">
            </div>
            <div class="col">
                <label>Landmark</label>
                <input type="text" name="addresses[${addressIndex}][landmark]" class="form-control">
            </div>
        </div>

        <div class="row mb-2">
            <div class="col">
                <label>City *</label>
                <input type="text" name="addresses[${addressIndex}][city]" class="form-control" required>
            </div>
            <div class="col">
                <label>State *</label>
                <input type="text" name="addresses[${addressIndex}][state]" class="form-control" required>
            </div>
            <div class="col">
                <label>Country *</label>
                <input type="text" name="addresses[${addressIndex}][country]" class="form-control" required>
            </div>
        </div>
    </div>`;
    wrapper.insertAdjacentHTML('beforeend', html);
    addressIndex++;
}
</script>
@endpush
