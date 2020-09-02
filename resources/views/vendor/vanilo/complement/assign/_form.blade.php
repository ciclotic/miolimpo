<div id="complements-assign-component">
<div id="complements-assign-to-model-modal" class="modal fade" tabindex="-1" role="dialog"
     aria-labelledby="complements-assign-to-model-modal-title" aria-hidden="true">

    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            {!! Form::open([
                    'url'  => route('vanilo.complement_value.sync', [$for, $forId]),
                    'method' => 'PUT'
                ])
            !!}

            <div class="modal-header">
                <h5 class="modal-title" id="complements-assign-to-model-modal">{{ __('Assign Properties') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <table class="table table-condensed table-striped">
                    <tbody>
                    <tr v-for="(assignedComplement, id) in assignedComplements" :id="id">
                        <th class="align-middle">@{{ assignedComplement.complement.name }}</th>
                        <td>
                            <select name="complementValues[]" v-model="assignedComplement.value" @change="onComplementValueChange($event, id)" class="form-control form-control-sm">
                                <option v-for="value in assignedComplement.values" :value="value.id" v-html="value.title"></option>
                                <optgroup label="{{ __('Missing value?') }}"></optgroup>
                                <option value="+">[+] {{ __('Add value') }}</option>
                            </select>
                        </td>
                        <td class="align-middle">
                            <i class="zmdi zmdi-close text-danger" style="cursor: pointer" @click="removeComplementValue(id)"></i>
                        </td>
                    </tr>
                    </tbody>
                    <tfoot>
                        <tr class="bg-success">
                            <th class="align-middle">{{ __('Unused complements') }}:</th>
                            <td>
                                <select v-model="selected" class="form-control form-control-sm">
                                    <option v-for="(unassignedComplement, id) in unassignedComplements" :value="id">
                                        @{{ unassignedComplement.complement.name }}
                                    </option>
                                </select>
                            </td>
                            <td class="align-middle">
                                <button class="btn btn-light btn-sm" type="button" :disabled="selected == ''"
                                        @click="addSelectedComplementValue">
                                    {{ __('Use complement') }}
                                </button>
                            </td>
                        </tr>
                    </tfoot>
                </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-dismiss="modal">{{ __('Close') }}</button>
                <button class="btn btn-primary">{{ __('Save complements') }}</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@include('vanilo::complement-value.assign._create_complement_value')

</div>

@section('scripts')
@parent()
<script>
    new Vue({
        //el: '#complements-assign-to-model-modal',
        el: '#complements-assign-component',
        data: {
            selected: "",
            adding: {
                "name": "",
                "complement_id": ""
            },
            assignedComplements: {
                @foreach($assignments as $complementValue)
                "{{ $complementValue->complement->id }}": {
                    "value": "{{ $complementValue->id }}",
                    "complement": {
                        "id":  "{{ $complementValue->complement->id }}",
                        "name": "{{ $complementValue->complement->name }}"
                    },
                    "values": [
                        @foreach($complementValue->complement->values() as $value)
                        {
                            "id": "{{ $value->id }}",
                            "title": "{{ $value->title }}"
                        },
                        @endforeach
                    ]
                },
                @endforeach
            },
            unassignedComplements: {
                @foreach($product->keyBy('id')->except($assignments->map(function ($complementValue) {
                        return $complementValue->complement->id;
                })->all()) as $unassignedComplement)
                "{{ $unassignedComplement->id }}": {
                    "value": "",
                    "complement": {
                        "id": "{{ $unassignedComplement->id }}",
                        "name": "{{ $unassignedComplement->name }}"
                    },
                    "values": [
                        @foreach($unassignedComplement->values() as $value)
                        {
                            "id": "{{ $value->id }}",
                            "title": "{{ $value->title }}"
                        },
                        @endforeach
                    ]
                },
                @endforeach
            }
        },
        methods: {
            addSelectedComplementValue() {
                if (this.selected && '' !== this.selected) {
                    var complement = this.unassignedComplements[this.selected];
                    if (complement) {
                        this.assignedComplements[complement.complement.id] = complement;
                        Vue.delete(this.unassignedComplements, complement.complement.id);
                    }
                }
            },
            removeComplementValue(complementId) {
                var complement = this.assignedComplements[complementId];
                if (complement) {
                    this.unassignedComplements[complementId] = complement;
                    Vue.delete(this.assignedComplements, complementId)
                }
            },
            onComplementValueChange(event, complementId) {
                var selected = this.assignedComplements[complementId].value;
                if ('+' !== selected) {
                    return;
                }

                this.adding.name = this.assignedComplements[complementId].complement.name;
                this.adding.complement_id = complementId;

                var url = "{{ route('vanilo.complement_value.create', '@@@') }}";
                window.open(url.replace('@@@', complementId), '_blank');
                //$('#create-complement-value').modal('show');
            }
        }
    });
</script>
@endsection
