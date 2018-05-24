<?php
/**
 * @author Cristiano Diniz da Silva <cdasilva@sonnysdirect.com>
 */

namespace NexmoClient;

/**
 * Describe a list of Response Codes that are returned by the API.
 *
 * @package NexmoClient
 */
final class NexmoResponseCodes
{

    /**
     * Represents a message that was successfully delivered.
     */
    const DELIVERED_RESPONSE = 0;

    /**
     * Represents a message that either: An unknown error was received from the carrier who tried to send this this
     * message. Depending on the carrier, that to is unknown. When you see this error, and status is rejected, always
     * check if to in your request was valid.
     */
    const ERROR_UNKNOWN = 1;

    /**
     * Represents a message that was not delivered because to was temporarily unavailable. For example, the handset
     * used for to was out of coverage or switched off. This is a temporary failure, retry later for a positive result.
     */
    const ERROR_ABSENT_SUBSCRIBER_TEMPORARY = 2;

    /**
     * Represents a message that the subscriber is no longer active, you should remove this phone number from your
     * database.
     */
    const ERROR_ABSENT_SUBSCRIBER_PERMANENT = 3;

    /**
     * Represents a message/call that is being blocked by the user. The only way to receive messages/calls is if the
     * user contacts the carrier.
     */
    const ERROR_CALL_BARRED_BY_USER = 4;

    /**
     * Represents a message/call that can't be received by the user because the portability from a carrier to another
     * was not properly done.
     */
    const ERROR_PORTABILITY = 5;

    /**
     * Represents a message/call that can't be delivered because the carrier pushed it into anti-spam.
     */
    const ERROR_ANTI_SPAM_REJECTION = 6;

    /**
     * Represents a message/call that couldn't be delivered because the handset associated with to was not available
     * when this message was sent. If status is Failed, this is a temporary failure; retry later for a positive result.
     * If status is Accepted, this message has is in the retry scheme and will be resent until it expires in 24-48
     * hours.
     */
    const ERROR_HANDSET_BUSY = 7;

    /**
     * A network failure while sending your message. This is a temporary failure, retry later for a positive result.
     */
    const ERROR_NETWORK = 8;

    /**
     * Represents a message that was attempted to be sent to a user that has already opted out. Blacklisted.
     */
    const ERROR_ILLEGAL_NUMBER = 9;

    /**
     * The message could not be sent because one of the parameters in the message was incorrect. For example, incorrect
     * type or udh.
     */
    const ERROR_INVALID_MESSAGE = 10;

    /**
     * There is an API routing issue. Contact Nexmo.
     */
    const ERROR_UNROUTABLE = 11;

    /**
     * Represents a message that could not be delivered to the phone number.
     */
    const ERROR_DESTINATION_UNREACHABLE = 12;

    /**
     * Represents a message/call that the carrier blocked this message because the content is not suitable for to based
     * on age restrictions.
     */
    const ERROR_SUBSCRIBER_AGE_RESTRICTION = 13;

    /**
     * Represents a message/call that the carrier blocked this message. This could be due to several reasons. For
     * example, to's plan does not include SMS or the account is suspended.
     */
    const ERROR_NUMBER_BLOCKED_BY_CARRIER = 14;

    /**
     * Represents a message/call that could not be delivered because of insufficient funds. To’s pre-paid account does
     * not have enough credit to receive the message.
     */
    const ERROR_PREPAID_INSUFFICIENT_FUNDS = 15;

    /**
     * There is an API issue. Contact Nexmo.
     */
    const ERROR_GENERAL = 99;
}