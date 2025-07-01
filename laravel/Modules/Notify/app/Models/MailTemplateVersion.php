<?php

declare(strict_types=1);

namespace Modules\Notify\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Xot\Traits\Updater;

/**
 * 
 *
 * @property int $id
 * @property int $mail_template_id
 * @property int $version
 * @property string|null $subject
 * @property string $html_template
 * @property string|null $text_template
 * @property array|null $metadata
 * @property string|null $created_by
 * @property string|null $change_notes
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property string|null $updated_by
 * @property string|null $deleted_by
 * @property-read \Modules\SaluteOra\Models\Profile|null $creator
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Modules\Media\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Modules\Notify\Models\MailTemplate|null $template
 * @property-read \Modules\SaluteOra\Models\Profile|null $updater
 * @method static \Modules\Notify\Database\Factories\MailTemplateVersionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailTemplateVersion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailTemplateVersion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailTemplateVersion onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailTemplateVersion query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailTemplateVersion whereChangeNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailTemplateVersion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailTemplateVersion whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailTemplateVersion whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailTemplateVersion whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailTemplateVersion whereHtmlTemplate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailTemplateVersion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailTemplateVersion whereMailTemplateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailTemplateVersion whereMetadata($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailTemplateVersion whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailTemplateVersion whereTextTemplate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailTemplateVersion whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailTemplateVersion whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailTemplateVersion whereVersion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailTemplateVersion withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MailTemplateVersion withoutTrashed()
 * @mixin \Eloquent
 */
class MailTemplateVersion extends BaseModel
{
    use SoftDeletes, Updater;

    /** @var string */
    protected $connection = 'notify';

    /** @var list<string> */
    protected $fillable = [
        'template_id',
        'mailable',
        'subject',
        'html_template',
        'text_template',
        'version',
        'created_by',
        'change_notes',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'metadata' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function template(): BelongsTo
    {
        return $this->belongsTo(MailTemplate::class, 'template_id');
    }

    public function restore(): MailTemplate
    {
        $template = $this->template;

        if ($template === null) {
            throw new \RuntimeException('Template non trovato per questa versione');
        }

        $template->update([
            'subject' => $this->subject,
            'html_template' => $this->html_template,
            'text_template' => $this->text_template,
        ]);

        return $template;
    }
}
