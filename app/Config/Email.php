<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Email extends BaseConfig
{
    /**
     * @var string
     */
    public string $fromEmail = 'learning@bandhanhara.com';

    /**
     * @var string
     */
    public string $fromName = 'Python Learning Platform';

    /**
     * The "user agent"
     *
     * @var string
     */
    public string $userAgent = 'CodeIgniter';

    /**
     * The mail sending protocol: mail, sendmail, smtp
     *
     * @var string
     */
    public string $protocol = 'smtp';

    /**
     * The server path to Sendmail.
     *
     * @var string
     */
    public string $mailPath = '/usr/sbin/sendmail';

    /**
     * SMTP Server Address
     * FastComet cPanel Email Settings:
     * Use mail.yourdomain.com format for FastComet shared hosting
     *
     * @var string
     */
    public string $SMTPHost = 'mail.bandhanhara.com';

    /**
     * SMTP Username
     * FastComet requires full email address as username
     *
     * @var string
     */
    public string $SMTPUser = 'learning@bandhanhara.com';

    /**
     * SMTP Password
     * Use the password set in cPanel Email Accounts
     *
     * @var string
     */
    public string $SMTPPass = '!BadPassw0rd';

    /**
     * SMTP Port
     * FastComet supports:
     * - Port 587 with STARTTLS/TLS (recommended)
     * - Port 465 with SSL/TLS (alternative)
     * - Port 25 (non-encrypted, may be blocked)
     *
     * @var int
     */
    public int $SMTPPort = 587;

    /**
     * SMTP Timeout (in seconds)
     * FastComet recommends 30 seconds for shared hosting
     *
     * @var int
     */
    public int $SMTPTimeout = 30;

    /**
     * Enable persistent SMTP connections
     * Keep disabled for FastComet shared hosting
     *
     * @var bool
     */
    public bool $SMTPKeepAlive = false;

    /**
     * SMTP Encryption. Either tls or ssl
     * FastComet settings:
     * - Use 'tls' for port 587 (STARTTLS)
     * - Use 'ssl' for port 465 (SSL/TLS)
     *
     * @var string
     */
    public string $SMTPCrypto = 'tls';

    /**
     * Enable word-wrap
     *
     * @var bool
     */
    public bool $wordWrap = true;

    /**
     * Character count to wrap at
     *
     * @var int
     */
    public int $wrapChars = 76;

    /**
     * Type of mail, either 'text' or 'html'
     *
     * @var string
     */
    public string $mailType = 'html';

    /**
     * Character set (utf-8, iso-8859-1, etc.)
     *
     * @var string
     */
    public string $charset = 'UTF-8';

    /**
     * Whether to validate the email address
     *
     * @var bool
     */
    public bool $validate = false;

    /**
     * Email Priority. 1 = highest. 5 = lowest. 3 = normal
     *
     * @var int
     */
    public int $priority = 3;

    /**
     * Newline character. (Use "\r\n" to comply with RFC 822)
     *
     * @var string
     */
    public string $CRLF = "\r\n";

    /**
     * Newline character. (Use "\r\n" to comply with RFC 822)
     *
     * @var string
     */
    public string $newline = "\r\n";

    /**
     * Enable BCC Batch Mode.
     *
     * @var bool
     */
    public bool $BCCBatchMode = false;

    /**
     * Number of emails in each BCC batch
     *
     * @var int
     */
    public int $BCCBatchSize = 200;

    /**
     * Enable notify message from server
     *
     * @var bool
     */
    public bool $DSN = false;
}

