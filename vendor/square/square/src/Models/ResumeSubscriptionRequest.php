<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Defines input parameters in a request to the
 * [ResumeSubscription]($e/Subscriptions/ResumeSubscription) endpoint.
 */
class ResumeSubscriptionRequest implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $resumeEffectiveDate;

    /**
     * @var string|null
     */
    private $resumeChangeTiming;

    /**
     * Returns Resume Effective Date.
     * The `YYYY-MM-DD`-formatted date when the subscription reactivated.
     */
    public function getResumeEffectiveDate(): ?string
    {
        return $this->resumeEffectiveDate;
    }

    /**
     * Sets Resume Effective Date.
     * The `YYYY-MM-DD`-formatted date when the subscription reactivated.
     *
     * @maps resume_effective_date
     */
    public function setResumeEffectiveDate(?string $resumeEffectiveDate): void
    {
        $this->resumeEffectiveDate = $resumeEffectiveDate;
    }

    /**
     * Returns Resume Change Timing.
     * Supported timings when a pending change, as an action, takes place to a subscription.
     */
    public function getResumeChangeTiming(): ?string
    {
        return $this->resumeChangeTiming;
    }

    /**
     * Sets Resume Change Timing.
     * Supported timings when a pending change, as an action, takes place to a subscription.
     *
     * @maps resume_change_timing
     * @factory \Square\Models\ChangeTiming::checkValue
     */
    public function setResumeChangeTiming(?string $resumeChangeTiming): void
    {
        $this->resumeChangeTiming = $resumeChangeTiming;
    }

    /**
     * Encode this object to JSON
     *
     * @param bool $asArrayWhenEmpty Whether to serialize this model as an array whenever no fields
     *        are set. (default: false)
     *
     * @return array|stdClass
     */
    #[\ReturnTypeWillChange] // @phan-suppress-current-line PhanUndeclaredClassAttribute for (php < 8.1)
    public function jsonSerialize(bool $asArrayWhenEmpty = false)
    {
        $json = [];
        if (isset($this->resumeEffectiveDate)) {
            $json['resume_effective_date'] = $this->resumeEffectiveDate;
        }
        if (isset($this->resumeChangeTiming)) {
            $json['resume_change_timing']  = ChangeTiming::checkValue($this->resumeChangeTiming);
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
