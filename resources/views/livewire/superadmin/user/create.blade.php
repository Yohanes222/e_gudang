<div wire:ignore.self class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah {{ $title }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <div class="row">
                <label for="name" class="form-label">Nama</label>
                <input wire:model="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Masukkan Nama">
            @error('name')
                <small class="text-danger">
                    {{ $message }}
                </small>
            @enderror
        </div>

        <div class="row">
                <label for="email" class="form-label">Email</label>
                <input wire:model="email" type="text" class="form-control @error('email') is-invalid @enderror" placeholder="Masukkan Email">
            @error('email')
                <small class="text-danger">
                    {{ $message }}
                </small>
            @enderror
        </div>

        <div class="row">
                <label for="role" class="form-label mr-2">Role</label>
                <select id="role" wire:model="role" class="form-control 
                @error('role') is-invalid
                @enderror">
                    <option selected disabled hidden>--Pilih Role--</option>
                    <option value="Super Admin">Super Admin</option>
                    <option value="Admin">Admin</option>
                </select>
            @error('role')
                <small class="text-danger">
                    {{ $message }}
                </small>
            @enderror
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
            <i class="fas fa-times mr-1"></i>
            Tutup
        </button>
        <button wire:click="store" type="button" class="btn btn-primary btn-sm">
            <i class="fas fa-save mr-1"></i>
            Simpan
        </button>
      </div>
    </div>
  </div>
</div>