<?php

namespace wcf\system\kas;

/**
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
     * @var \KasApi\KasConfiguration
     */
    protected $configuration;

    /**
     * @var \KasApi\KasApi
     */
    protected $api;

    /**
     * Creates a new KasApi
     * @param string $login
     * @param string $authData
     * @param string $autType
     * @param bool $autodelay
     */
    public function __construct($login = null, $authData = null, $authType = null, $autodelay = false)
    {
        require_once(WCF_DIR . 'lib/system/api/kasapi-php/autoload.php');
        if (!isset($login)) {
            $login = KAS_LOGIN;
        }
        if (!isset($authData)) {
            $authData = KAS_AUTH_DATA;
        }
        if (!isset($authType)) {
            $authType = KAS_AUTH_TYPE;
        }
        if (!isset($autodelay)) {
            $authType = false;
        }

        $this->configuration = new \KasApi\KasConfiguration($login, $authData, $authType, $autodelay);
        $this->api = new  \KasApi\KasApi($this->configuration);
    }

    /**
     * @throws \KasApi\KasApiException
     */
    public function __call($name, $arguments)
    {
        return $this->api->$name($arguments);
    }

    /**
     * @return \KasApi\KasConfiguration
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }
}
