# RecordNotification Documentation

## Overview
The `RecordNotification` class is a Laravel notification that handles sending notifications for model records via multiple channels (email and SMS). It supports dynamic data merging and file attachments, making it suitable for complex notification scenarios.

## Location
`/laravel/Modules/Notify/app/Notifications/RecordNotification.php`

## Class Structure

### Namespace
```php
namespace Modules\Notify\Notifications;
```

### Inheritance
Extends `Illuminate\Notifications\Notification`

### Dependencies
- `Illuminate\Support\Str` - String manipulation utilities
- `Modules\Notify\Datas\SmsData` - SMS data structure
- `Modules\Notify\Emails\SpatieEmail` - Email handling class
- `Illuminate\Database\Eloquent\Model` - Base model class
- `Modules\Notify\Channels\SmsChannel` - Custom SMS notification channel
- `Modules\Notify\Models\MailTemplate` - Mail template model
- `Illuminate\Notifications\Notification` - Base notification class

## Properties

### Protected Properties
- `protected Model $record` - The model record associated with the notification
- `protected string $slug` - Slugified identifier for the notification type

### Public Properties
- `public array $data = []` - Additional data to merge into the notification
- `public array $attachments = []` - File attachments for the notification

## Methods

### __construct()
Initializes the notification with a model record and slug identifier.

#### Parameters
- `Model $record` - The model record to notify about
- `string $slug` - Notification type identifier (will be slugified)

#### Implementation
```php
public function __construct(Model $record, string $slug)
{
    $this->record = $record;
    $this->slug = Str::slug($slug);
}
```

### via()
Determines which notification channels to use based on the notifiable's routing configuration.

#### Parameters
- `object $notifiable` - The entity being notified

#### Return Type
`array<string|class-string>` - Array of notification channels

#### Logic Flow
1. Checks if notifiable has `routeNotificationFor` method
2. Returns empty array if method doesn't exist
3. Adds 'mail' channel if email routing is configured
4. Adds `SmsChannel::class` if SMS routing is configured

#### Implementation
```php
public function via($notifiable): array
{
    $channels = [];
    if (!method_exists($notifiable, 'routeNotificationFor')){
        return $channels;
    }
    if($notifiable->routeNotificationFor('mail')) {
        $channels[] = 'mail';
    }
    if($notifiable->routeNotificationFor('sms')) {
        $channels[] = SmsChannel::class;
    }
    return $channels;
}
```

### toMail()
Generates the email representation of the notification.

#### Parameters
- `object $notifiable` - The entity being notified

#### Return Type
`SpatieEmail` - Configured email object

#### Process Flow
1. Creates new `SpatieEmail` instance with record and slug
2. Merges additional data using `mergeData()`
3. Adds attachments using `addAttachments()`
4. Configures recipient if notifiable has email routing
5. Sets recipient address for email delivery

#### Implementation
```php
public function toMail($notifiable): SpatieEmail
{
    $email = new SpatieEmail($this->record, $this->slug);
    $email = $email->mergeData($this->data);
    $email = $email->addAttachments($this->attachments);

    // Ensure there's always a recipient
    if (method_exists($notifiable, 'routeNotificationFor')) {
        $to = $notifiable->routeNotificationFor('mail');
        $email->to($to);
        if ($to) {
            $email->setRecipient($to);
        }
    }

    return $email;
}
```

### toSms()
Generates the SMS representation of the notification.

#### Parameters
- `object $notifiable` - The entity being notified

#### Return Type
`?SmsData` - SMS data object or null if no SMS routing

#### Process Flow
1. Creates `SpatieEmail` instance to generate SMS content
2. Merges additional data
3. Extracts SMS routing information from notifiable
4. Returns null if no SMS routing configured
5. Creates and returns `SmsData` object with SMS content

#### Implementation
```php
public function toSms(object $notifiable): ?SmsData
{
    $email = new SpatieEmail($this->record, $this->slug);
    $email = $email->mergeData($this->data);
   
    $to = null;
    if (method_exists($notifiable, 'routeNotificationFor')) {
        $to = $notifiable->routeNotificationFor('sms');
    }
    if($to == null){
        return null;
    }

    $smsData = SmsData::from([
        'from' => 'Xot',
        'to' => $to,
        'body' => $email->buildSms(),
    ]);

    return $smsData;
}
```

### mergeData()
Merges additional data into the notification's data array.

#### Parameters
- `array $data` - Data to merge

#### Return Type
`self` - Returns the notification instance for method chaining

#### Implementation
```php
public function mergeData(array $data): self
{
    $this->data = array_merge($this->data, $data);
    return $this;
}
```

### addAttachments()
Adds file attachments to the notification.

#### Parameters
- `array $attachments` - Array of attachment data

#### Return Type
`self` - Returns the notification instance for method chaining

#### Implementation
```php
public function addAttachments(array $attachments): self
{
    $this->attachments = array_merge($this->attachments, $attachments);
    return $this;
}
```

## Usage Examples

### Basic Notification
```php
$notification = new RecordNotification($appointment, 'appointment-confirmed');
$user->notify($notification);
```

### With Additional Data
```php
$notification = new RecordNotification($appointment, 'appointment-confirmed');
$notification->mergeData([
    'doctor_name' => $appointment->doctor->name,
    'appointment_time' => $appointment->starts_at->format('Y-m-d H:i')
]);
$user->notify($notification);
```

### With Attachments
```php
$notification = new RecordNotification($appointment, 'report-completed');
$notification->addAttachments([
    [
        'as' => 'report.pdf',
        'data' => $pdfContent,
    ]
]);
$user->notify($notification);
```

### Method Chaining
```php
$user->notify(
    (new RecordNotification($appointment, 'appointment-reminder'))
        ->mergeData(['reminder_time' => '1 hour'])
        ->addAttachments($reportAttachments)
);
```

## Integration Points

### With SpatieEmail
The notification creates `SpatieEmail` instances for both email and SMS content generation. The email class handles:
- Template rendering
- Data merging
- Attachment processing
- Content formatting

### With State Transitions
Used by state transition classes to send notifications with attachments:

```php
// In BaseTransition
$notification = new RecordNotification($this->record, $this->getNotificationSlug());
$notification->mergeData($this->getNotificationData());
$notification->addAttachments($this->getNotificationAttachments());
$notifiable->notify($notification);
```

### With Notification Channels
- **Mail Channel**: Uses Laravel's built-in mail channel with `SpatieEmail`
- **SMS Channel**: Uses custom `SmsChannel` with `SmsData`

## Attachment Structure

### Expected Format
```php
[
    [
        'as' => 'filename.pdf',        // Display name for attachment
        'data' => $binaryContent,      // Raw file content
    ],
    [
        'path' => '/path/to/file.pdf', // File system path
        'as' => 'custom-name.pdf',     // Optional custom name
    ]
]
```

### Processing
Attachments are processed by the `SpatieEmail` class which:
1. Converts data/path arrays to Laravel `Attachment` objects
2. Validates file existence for path-based attachments
3. Handles both raw data and file path attachments

## Error Handling

### Potential Issues
1. **Missing Routing Methods**: If notifiable doesn't implement `routeNotificationFor`
2. **Invalid Attachments**: If attachment data is malformed
3. **Template Errors**: If email template rendering fails
4. **SMS Routing**: If SMS routing returns invalid phone number

### Defensive Programming
The class includes several defensive checks:
- Method existence validation before calling `routeNotificationFor`
- Null checks for routing results
- Empty array returns for missing routing methods

## Best Practices

### Data Management
1. **Sanitize Data**: Ensure merged data is properly sanitized
2. **Validate Attachments**: Verify attachment data before adding
3. **Memory Management**: Be mindful of large attachments in memory

### Error Handling
1. **Log Failures**: Implement logging for notification failures
2. **Graceful Degradation**: Handle missing routing gracefully
3. **Validation**: Validate notifiable objects before processing

### Performance
1. **Lazy Loading**: Consider lazy loading for large attachments
2. **Queue Processing**: Use queued notifications for heavy processing
3. **Caching**: Cache template rendering where appropriate

## Configuration Requirements

### Notifiable Classes
Must implement `routeNotificationFor` method:
```php
public function routeNotificationFor($channel)
{
    switch ($channel) {
        case 'mail':
            return $this->email;
        case 'sms':
            return $this->phone;
        default:
            return null;
    }
}
```

### Channel Configuration
- Mail channel: Standard Laravel mail configuration
- SMS channel: Custom channel implementation required

## Related Files
- `SpatieEmail.php` - Email handling and template rendering
- `SmsData.php` - SMS data structure
- `SmsChannel.php` - Custom SMS notification channel
- `BaseTransition.php` - State transition notification integration
- `MailTemplate.php` - Email template model

## Testing Considerations

### Test Scenarios
1. **Channel Selection**: Test via() method with different notifiable configurations
2. **Email Generation**: Test toMail() with various data and attachments
3. **SMS Generation**: Test toSms() with valid/invalid routing
4. **Data Merging**: Test mergeData() with various data structures
5. **Attachment Handling**: Test addAttachments() with different formats

### Mock Requirements
- Mock notifiable objects with routing methods
- Mock SpatieEmail for email testing
- Mock SmsData for SMS testing
- Mock attachment data for file handling tests

## Future Improvements

### Recommended Enhancements
1. **Validation**: Add validation for attachment data structure
2. **Error Handling**: Improve error handling and logging
3. **Performance**: Implement attachment streaming for large files
4. **Flexibility**: Add support for additional notification channels
5. **Templates**: Support for dynamic template selection based on record type
