<div>
    <label class="toggle-switch" for="toggle-{{ $model->id }}">
        <input class="custom-control-input" type="checkbox" id="toggle-{{ $model->id }}" wire:model.live="isPublished"
            name="toggle-{{ $model->id }}">
        <span class="toggle-slider"></span>
    </label>
</div>
