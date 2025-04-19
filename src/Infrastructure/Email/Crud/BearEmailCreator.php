<?php declare(strict_types=1);

namespace GuardsmanPanda\Larabear\Infrastructure\Email\Crud;

use Carbon\CarbonInterface;
use GuardsmanPanda\Larabear\Infrastructure\Email\Model\BearEmail;
use GuardsmanPanda\Larabear\Infrastructure\Database\Service\BearDatabaseService;
use GuardsmanPanda\Larabear\Infrastructure\Email\Service\BearEmailService;
use GuardsmanPanda\Larabear\Infrastructure\Error\Crud\BearErrorCreator;
use Illuminate\Database\Eloquent\Casts\ArrayObject;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

final class BearEmailCreator {
    /**
     * @param string $email_to
     * @param string $email_subject
     * @param string|null $email_cc
     * @param string|null $email_bcc
     * @param string|null $email_tag
     * @param string|null $email_reply_to
     * @param CarbonInterface|null $email_sent_at
     * @param string|null $email_text
     * @param string|null $email_html
     * @param bool $sandbox
     * @param ArrayObject<string, mixed> $additional_data_json
     * @return BearEmail
     */
    public static function create(
        string $email_to,
        string $email_subject,
        string $email_cc = null,
        string $email_bcc = null,
        string $email_tag = null,
        string $email_reply_to = null,
        CarbonInterface $email_sent_at = null,
        string $email_text = null,
        string $email_html = null,
        bool $sandbox = false,
        ArrayObject $additional_data_json = new ArrayObject([]),
    ): BearEmail {
        BearDatabaseService::mustBeInTransaction();

        $model = new BearEmail();
        $model->id = Str::uuid()->toString();

        $model->email_to = $email_to;
        $model->email_subject = $email_subject;
        $model->email_cc = $email_cc === null ? null : trim(string: $email_cc, characters: ', ');
        $model->email_bcc = $email_bcc === null ? null : trim(string: $email_bcc, characters: ', ');
        $model->email_tag = $email_tag;
        $model->email_reply_to = $email_reply_to;
        $model->email_sent_at = $email_sent_at;
        $model->email_text = $email_text;
        $model->email_html = $email_html;
        $model->is_sandboxed = $sandbox;
        $model->additional_data_json = $additional_data_json;

        $model->save();

        try {
            DB::beginTransaction();
             $model = BearEmailService::sendEmail(email: $model);
            DB::commit();
        } catch (Throwable $t) {
            DB::rollBack();
            BearErrorCreator::create(
                message: "Failure to send email [{$t->getMessage()}]",
                key: 'larabear::email-send-command',
                exception: $t
            );
        }

        return $model;
    }
}
