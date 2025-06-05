<div class="space-y-4">
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Riepilogo Dati Medico</h3>
        
        @php
            $workflow = \Modules\SaluteOra\Models\DoctorRegistrationWorkflow::find(session('doctor_registration_workflow_id'));
            $personalInfo = $workflow?->step_data['personal_info'] ?? [];
        @endphp

        @if($workflow)
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Nome Completo</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $personalInfo['full_name'] ?? 'N/D' }}</dd>
                </div>

                @if(isset($personalInfo['certification']))
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Certificazione Ordine</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            <a href="{{ Storage::url($personalInfo['certification']) }}" 
                               target="_blank"
                               class="text-blue-600 hover:text-blue-800">
                                Visualizza Documento
                            </a>
                        </dd>
                    </div>
                @endif
            </div>

            <div class="mt-6">
                <dt class="text-sm font-medium text-gray-500">Stato Workflow</dt>
                <dd class="mt-1">
                    <span @class([
                        'px-2 py-1 text-xs font-medium rounded-full',
                        'bg-yellow-100 text-yellow-800' => $workflow->isPendingModeration(),
                        'bg-green-100 text-green-800' => $workflow->isModerationApproved(),
                        'bg-red-100 text-red-800' => $workflow->isModerationRejected(),
                    ])>
                        {{ match($workflow->status) {
                            'pending_moderation' => 'In Attesa di Moderazione',
                            'moderation_approved' => 'Approvato',
                            'moderation_rejected' => 'Rifiutato',
                            default => 'Stato Sconosciuto'
                        } }}
                    </span>
                </dd>
            </div>

            @if($workflow->moderated_at)
                <div class="mt-4">
                    <dt class="text-sm font-medium text-gray-500">Data Moderazione</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        {{ $workflow->moderated_at->format('d/m/Y H:i') }}
                    </dd>
                </div>
            @endif

            @if($workflow->moderation_notes)
                <div class="mt-4">
                    <dt class="text-sm font-medium text-gray-500">Note Moderazione</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        {{ $workflow->moderation_notes }}
                    </dd>
                </div>
            @endif
        @else
            <p class="text-sm text-gray-500">Nessun workflow di registrazione trovato.</p>
        @endif
    </div>
</div> 