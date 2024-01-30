<?php

namespace App\Entity;

/**
 * Class Workflow
 * @package App\Entity
 */
class Workflow
{
    // landing and article
    const REDACTION = 'redaction';
    const REDACTED  = 'redacted';
    const VALIDATED = 'validated';
    const REFUSED   = 'refused';
    const PUBLISHED = 'published';

    // job
    const ONLINE = 'online';
    const TAKEN  = 'taken';

    /**
     * @param string $transition
     *
     * @return string
     */
    public function resolveTransitionName(string $transition): string
    {
        // Switch name
        switch ($transition)
        {
            case 'to_redacted':
                return 'Rediger';
                break;
            case 'to_validated':
                return 'Valider';
                break;
            case 'to_refused':
                return 'Refuser';
                break;
            case 'to_published':
                return 'Publier';
                break;
            case 'back_to_redaction':
                return 'Redaction';
                break;
            case 'to_unpublished':
                return 'Dépublier';
                break;

            case 'to_taken':
                return 'Pourvue';
                break;
            case 'back_online':
                return 'Republier';
                break;

            default:
                return 'To implement see resolveTransitionName';
        }
    }

    /**
     * @param string $status
     *
     * @return string
     */
    public function resolveStatusName(string $status): string
    {
        // Switch name
        switch ($status)
        {
            case self::REDACTION:
                return 'Redaction';
                break;
            case self::REDACTED:
                return 'Rediger';
                break;
            case self::VALIDATED:
                return 'Valider';
                break;
            case self::REFUSED:
                return 'Refuser';
                break;
            case self::PUBLISHED:
            case self::ONLINE:
                return 'En ligne';
                break;

            case self::TAKEN:
                return 'Pourvue';
                break;

            default:
                return 'To implement see resolveStatusName';
        }
    }

    /**
     * @param string $status
     *
     * @return string
     */
    public function resolveStatusColor(string $status): string
    {
        switch ($status)
        {
            case self::REDACTION:
                return 'secondary';
                break;
            case self::REDACTED:
            case self::ONLINE:
                return 'primary';
                break;
            case self::VALIDATED:
                return 'info';
                break;
            case self::REFUSED:
                return 'danger';
                break;
            case self::PUBLISHED:
            case self::TAKEN:
                return 'success';
                break;

            default:
                return 'To implement see resolverStatusColor';
        }
    }
}
