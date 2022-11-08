<?php

namespace KasApi;

use SoapFault;

/**
 * Calls the KAS API.
 * Ensures that the given API functions and parameters are valid
 *
 * @package KasApi
 *
 * @method get_accountresources()
 * @method get_accounts(array $params)
 * @method get_accountsettings()
 * @method get_server_information()
 * @method get_cronjobs(array $params)
 * @method get_databases(array $params)
 * @method get_ddnsusers(array $params)
 * @method get_directoryprotection(array $params)
 * @method get_dns_settings(array $params)
 * @method get_domains(array $params)
 * @method get_topleveldomains()
 * @method get_ftpusers(array $params)
 * @method get_mailaccounts(array $params)
 * @method get_mailstandardfilter()
 * @method get_mailforwards(array $params)
 * @method get_mailinglists(array $params)
 * @method get_softwareinstall(array $params)
 * @method get_space(array $params)
 * @method get_space_usage(array $params)
 * @method get_traffic(array $params)
 * @method get_subdomains(array $params)
 * @method get_dkim(array $params)
 * @method add_account(array $params)
 * @method add_cronjob(array $params)
 * @method add_database(array $params)
 * @method add_ddnsuser(array $params)
 * @method add_directoryprotection(array $params)
 * @method add_dns_settings(array $params)
 * @method add_domain(array $params)
 * @method add_ftpuser(array $params)
 * @method delete_account(array $params)
 * @method update_account(array $params)
 * @method update_accountsettings(array $params)
 * @method update_superusersettings(array $params)
 * @method update_chown(array $params)
 * @method delete_cronjob(array $params)
 * @method update_cronjob(array $params)
 * @method delete_database(array $params)
 * @method update_database(array $params)
 * @method delete_ddnsuser(array $params)
 * @method update_ddnsuser(array $params)
 * @method delete_directoryprotection(array $params)
 * @method update_directoryprotection(array $params)
 * @method delete_dns_settings(array $params)
 * @method reset_dns_settings(array $params)
 * @method update_dns_settings(array $params)
 * @method delete_domain(array $params)
 * @method update_domain(array $params)
 * @method move_domain(array $params)
 * @method delete_ftpuser(array $params)
 * @method update_ftpuser(array $params)
 * @method add_mailaccount(array $params)
 * @method delete_mailaccount(array $params)
 * @method update_mailaccount(array $params)
 * @method add_mailstandardfilter(array $params)
 * @method delete_mailstandardfilter(array $params)
 * @method add_mailforward(array $params)
 * @method delete_mailforward(array $params)
 * @method update_mailforward(array $params)
 * @method add_mailinglist(array $params)
 * @method delete_mailinglist(array $params)
 * @method update_mailinglist(array $params)
 * @method add_sambauser(array $params)
 * @method delete_sambauser(array $params)
 * @method update_sambauser(array $params)
 * @method add_session(array $params)
 * @method add_softwareinstall(array $params)
 * @method add_subdomain(array $params)
 * @method delete_subdomain(array $params)
 * @method update_subdomain(array $params)
 * @method move_subdomain(array $params)
 * @method add_dkim(array $params)
 * @method delete_dkim(array $params)
 * @method update_ssl(array $params)
 * @method add_symlink(array $params)
 */
class KasApi
{
    /**
     * KasConfiguration object
     *
     * @var KasConfiguration
     */
    protected $kasConfiguration;

    /**
     * Contains every API function and its parameters.
     * Adjust if the KAS API is updated; ! means required parameter
     *
     * @var array
     */
    protected $functions = [
        'get_accountresources' => '',
        'get_accounts' => 'account_login',
        'get_accountsettings' => '',
        'get_server_information' => '',
        'get_cronjobs' => 'cronjob_id',
        'get_databases' => 'database_login',
        'get_ddnsusers' => 'ddns_login',
        'get_directoryprotection' => 'directory_path',
        'get_dns_settings' => 'zone_host!, record_id',
        'get_domains' => 'domain_name',
        'get_topleveldomains' => '',
        'get_ftpusers' => 'ftp_login',
        'get_mailaccounts' => 'mail_login',
        'get_mailstandardfilter' => '',
        'get_mailforwards' => 'mail_forward',
        'get_mailinglists' => 'mailinglist_name',
        'get_softwareinstall' => 'software_id',
        'get_space' => 'show_subaccounts, show_details',
        'get_space_usage' => 'directory!',
        'get_traffic' => 'year', 'month',
        'get_subdomains' => 'subdomain_name',
        'get_dkim' => 'host!',
        'add_account' => 'account_kas_password!, account_ftp_password!, account_comment, account_contact_mail, hostname_art, hostname_part1, hostname_part2, hostname_path, max_account, max_domain, max_subdomain, max_webspace, max_mail_account, max_mail_forward, max_mailinglist, max_database, max_ftpuser, max_sambauser, max_cronjobs, inst_htaccess, inst_fpse, kas_access_forbidden, inst_software, logging, logage, statistic, dns_settings, show_password',
        'add_cronjob' => 'protocol!, http_url!, cronjob_comment!, minute!, hour!, day_of_month!, month!, day_of_week!, http_user, http_password, mail_address, mail_condition, mail_subject, is_active',
        'add_database' => 'database_password!, database_comment!, database_allowed_hosts',
        'add_ddnsuser' => 'dyndns_comment!, dyndns_password!, dyndns_zone!, dyndns_label!, dyndns_target_ip!',
        'add_directoryprotection' => 'directory_user!, directory_path!, directory_password!, directory_authname!',
        'add_dns_settings' => 'zone_host!, record_type!, record_name!, record_data!, record_aux!',
        'add_domain' => 'domain_name!, domain_tld!, domain_path, redirect_status, statistic_version, statistic_language,php_version',
        'add_ftpuser' => 'ftp_password!, ftp_comment!, ftp_path, ftp_permission_read, ftp_permission_write, ftp_permission_list, ftp_virus_clamav',
        'delete_account' => 'account_login!',
        'update_account' => 'account_login!, account_kas_password!, max_account, max_domain, max_subdomain, max_webspace, max_mail_account, max_mail_forward, max_mailinglist, max_database, max_ftpuser, max_sambauser, max_cronjobs, inst_htaccess, inst_fpse, kas_access_forbidden, show_password, inst_software, logging, logage, statistic, dns_settings, account_comment, account_contact_mail',
        'update_accountsettings' => 'account_password, show_password, logging, logage, statistic, account_comment, account_contact_mail',
        'update_superusersettings' => 'account_login!, ssh_access, ssh_keys',
        'update_chown' => 'chown_path!, chown_user!, recursive!',
        'delete_cronjob' => 'cronjob_id!',
        'update_cronjob' => 'cronjob_id!, protocol, http_url, cronjob_comment, minute, hour, day_of_month, month, day_of_week, http_user, http_password, mail_address, mail_condition, mail_subject, is_active',
        'delete_database' => 'database_login!',
        'update_database' => 'database_login!, database_new_password, database_comment, database_allowed_hosts',
        'delete_ddnsuser' => 'dyndns_login!',
        'update_ddnsuser' => 'dyndns_login!, dyndns_password, dyndns_comment',
        'delete_directoryprotection' => 'directory_user!, directory_path!',
        'update_directoryprotection' => 'directory_user!, directory_path!, directory_password!, directory_authname!',
        'delete_dns_settings' => 'record_id!',
        'reset_dns_settings' => 'zone_host!, nameserver',
        'update_dns_settings' => 'record_id!, record_name, record_data, record_aux',
        'delete_domain' => 'domain_name!',
        'update_domain' => 'domain_name!, domain_path, redirect_status, php_version, is_active',
        'move_domain' => 'domain_name!, source_account!, target_account!',
        'delete_ftpuser' => 'ftp_login!',
        'update_ftpuser' => 'ftp_login!, ftp_path, ftp_new_password, ftp_comment, ftp_permission_read, ftp_permission_write, ftp_permission_list, ftp_virus_clamav',
        'add_mailaccount' => 'mail_password!, show_password, local_part!, domain_part!, responder, mail_responder_content_type, mail_responder_displayname, responder_text, copy_adress, mail_sender_alias, mail_xlist_enabled, mail_xlist_sent, mail_xlist_drafts, mail_xlist_trash, mail_xlist_spam, mail_xlist_archiv',
        'delete_mailaccount' => 'mail_login!',
        'update_mailaccount' => 'mail_login!, mail_new_password, show_password, responder, mail_responder_content_type, mail_responder_displayname, responder_text, copy_adress, is_active, mail_sender_alias, mail_xlist_enabled, mail_xlist_sent, mail_xlist_drafts, mail_xlist_trash, mail_xlist_spam, mail_xlist_archiv',
        'add_mailstandardfilter' => 'mail_login!, filter!',
        'delete_mailstandardfilter' => 'mail_login!',
        'add_mailforward' => 'local_part!, domain_part!, target_N',
        'delete_mailforward' => 'mail_forward!',
        'update_mailforward' => 'mail_forward!, target_N',
        'add_mailinglist' => 'mailinglist_name!, mailinglist_domain!, mailinglist_password!',
        'delete_mailinglist' => 'mailinglist_name!',
        'update_mailinglist' => 'mailinglist_name!, subscriber, restrict_post, config, is_active',
        'add_sambauser' => 'samba_path!, samba_new_password!, samba_comment',
        'delete_sambauser' => 'samba_login!',
        'update_sambauser' => 'samba_login!, samba_path, samba_new_password, samba_comment',
        'add_session' => 'session_lifetime!, session_update_lifetime!, session_2fa',
        'add_softwareinstall' => 'software_id!, software_database!, software_hostname!, software_install_example_data, software_path!, software_admin_mail!, software_admin_user!, software_admin_pass!, language',
        'add_subdomain' => 'subdomain_name!, domain_name!, subdomain_path, redirect_status, statistic_version, statistic_language, php_version',
        'delete_subdomain' => 'subdomain_name!',
        'update_subdomain' => 'subdomain_name!, subdomain_path, redirect_status, php_version, is_active',
        'move_subdomain' => 'subdomain_name!, source_account!, target_account!',
        'add_dkim' => 'host!, check_foreign_nameserver',
        'delete_dkim' => 'host!',
        'update_ssl' => 'hostname!, ssl_certificate_is_active, ssl_certificate_sni_csr, ssl_certificate_sni_key!, ssl_certificate_sni_crt!, ssl_certificate_sni_bundle, ssl_certificate_force_https, ssl_certificate_hsts_max_age',
        'add_symlink' => 'symlink_target!, symlink_name!'
    ];

    /**
     * Sets KasConfiguration
     *
     * @param object $kas_configuration
     */
    function __construct($kas_configuration)
    {
        @session_start();

        $this->kasConfiguration = $kas_configuration;
    }

    /**
     * Calls an API function with parameters.
     * Does not validate function name or parameters
     *
     * @param string $function
     * @param array $params
     * @return string
     * @throws KasApiException
     */
    protected function call($function, $params)
    {
        try {
            if ($this->kasConfiguration->_autoDelayApiCalls && (isset($_SESSION['KasNextCallTimestamp']) && ($now = time()) < $_SESSION['KasNextCallTimestamp']))
                sleep($_SESSION['KasNextCallTimestamp'] - $now);
            unset($_SESSION['KasNextCallTimestamp']);
            $data = ['KasUser' => $this->kasConfiguration->_login,
                'KasAuthType' => $this->kasConfiguration->_authType,
                'KasAuthData' => $this->kasConfiguration->_authData,
                'KasRequestType' => $function,
                'KasRequestParams' => $params];
            $kasSoapClient = (new KasSoapClient($this->kasConfiguration->wsdl_api))->getInstance();
            $result = $kasSoapClient->KasApi(json_encode($data));
            $_SESSION['KasNextCallTimestamp'] = time() + $result['Response']['KasFloodDelay'];
            return $result['Response']['ReturnInfo'];
        } catch (SoapFault $fault) {
            throw new KasApiException("SOAP-ENV:Server", ($fault->faultstring ?? ""), ($fault->faultactor ?? null), ($fault->detail ?? null));
        }
    }

    /**
     * Whether an API function exists
     *
     * @param string $function
     * @return boolean
     */
    protected function functionExists($function)
    {
        return array_key_exists($function, $this->functions);
    }

    /**
     * Whether a parameter is required
     *
     * @param string $param
     * @return boolean
     */
    protected function paramIsRequired($param)
    {
        return substr($param, -1) === "!";
    }

    /**
     * Gets parameters from a function argument list
     *
     * @param array $arguments
     * @return array
     */
    protected function getParamsFromArguments($arguments)
    {
        return $arguments[0][0] ?? [];
    }

    /**
     * Returns an array of allowed parameters for an API function
     *
     * @param string $function
     * @return string[]
     */
    protected function allowedParams($function)
    {
        $params = explode(',', $this->functions[$function]);
        return array_map('trim', $params);
    }

    /**
     * Returns an array of required parameters for an API function
     *
     * @param string $function
     * @return string[]
     */
    protected function requiredParams($function)
    {
        $params = array_map('trim', explode(',', $this->functions[$function]));
        $required_params = [];
        foreach ($params as $param)
            if ($this->paramIsRequired($param))
                $required_params[] = str_replace('!', '', $param);
        return $required_params;
    }

    /**
     * Whether the given parameter is neither required nor optional
     *
     * @param string $param
     * @param string $function
     * @return boolean
     */
    protected function paramIsAllowed($param, $function)
    {
        $allowed_params = $this->allowedParams($function);
        return in_array("$param!", $allowed_params) || in_array($param, $allowed_params) || (preg_match('/_[0-9]+$/', $param) && in_array("target_N", $allowed_params) && strpos($param, 'target_') !== false);
    }

    /**
     * Ensures that the given parameters contain every required parameter.
     * Also ensures there are no unnecessary parameters
     *
     * @param string $function
     * @param array $given_params
     * @return void
     * @throws KasApiException
     */
    protected function ensureFunctionParams($function, $given_params)
    {
        // ensure every required param is there
        $params = $this->requiredParams($function);
        foreach ($params as $param)
            if (!array_key_exists($param, $given_params))
                throw new KasApiException("SOAP-ENV:Server", "Parameter '$param' not given", "KasApi");
        // ensure every given param is allowed
        foreach ($given_params as $param => $value)
            if (!$this->paramIsAllowed($param, $function))
                throw new KasApiException("SOAP-ENV:Server", "Parameter '$param' may not be used", "KasApi");
    }

    /**
     * Is called whenever an API call is requested, then validates and executes the call.
     * e.g.: KasApi::get_domains();
     * or: KasApi::get_dns_settings(['zone_host' => 'example.com.']);
     * $function describes which function may be called and what params are valid
     *
     * @param string $function
     * @param array $arguments
     * @return string
     * @throws KasApiException
     */
    public function __call($function, $arguments)
    {
        if ($this->functionExists($function)) {
            $params = $this->getParamsFromArguments($arguments);
            $this->ensureFunctionParams($function, $params);
            return $this->call($function, $params);
        } else
            throw new KasApiException("SOAP-ENV:Server", "Function '$function' does not exist", "KasApi");
    }
}
