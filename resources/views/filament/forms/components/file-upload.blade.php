<x-dynamic-component
    :component="$getFieldWrapperView()"
    :id="$getId()"
    :label="$getLabel()"
    :label-sr-only="$isLabelHidden()"
    :helper-text="$getHelperText()"
    :hint="$getHint()"
    :hint-action="$getHintAction()"
    :hint-color="$getHintColor()"
    :hint-icon="$getHintIcon()"
    :required="$isRequired()"
    :state-path="$getStatePath()"
>
    <input wire:model.defer="{{ $getStatePath() }}" type="text" id="image_label" class="form-control" name="image"
           aria-label="Image" aria-describedby="button-image">
    <div class="input-group-append">
        <button onclick="window.open('/file-manager/fm-button', 'fm', 'width=1400,height=800');" class="btn btn-outline-secondary" type="button" id="button-image">Select</button>
    </div>

</x-dynamic-component>
