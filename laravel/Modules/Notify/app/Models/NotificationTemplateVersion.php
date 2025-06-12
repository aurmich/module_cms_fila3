<?php

declare(strict_types=1);

namespace Modules\Notify\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Xot\Traits\Updater;

// BaseModel in same namespace provides common behaviors
/**
 * 
 *
 * @property-read \Modules\SaluteOra\Models\Profile|null $creator
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Modules\Media\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Modules\Notify\Models\NotificationTemplate|null $template
 * @property-read \Modules\SaluteOra\Models\Profile|null $updater
 * @method static \Modules\Notify\Database\Factories\NotificationTemplateVersionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationTemplateVersion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationTemplateVersion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotificationTemplateVersion query()
 * @mixin \Eloquent
 */
class NotificationTemplateVersion extends BaseModel
{
    use Updater;

    protected $fillable = [
        'template_id',
        'subject',
        'body_html',
        'body_text',
        'channels',
        'variables',
        'conditions',
        'version',
        'created_by',
        'change_notes',
    ];

    protected $casts = [
        'channels' => 'array',
        'variables' => 'array',
        'conditions' => 'array',
    ];

    public function template(): BelongsTo
    {
        return $this->belongsTo(NotificationTemplate::class, 'template_id');
    }

    public function restore(): NotificationTemplate
    {
        $template = $this->template;
        
        $template->update([
            'subject' => $this->subject,
            'body_html' => $this->body_html,
            'body_text' => $this->body_text,
            'channels' => $this->channels,
            'variables' => $this->variables,
            'conditions' => $this->conditions,
        ]);

        return $template;
    }
} 