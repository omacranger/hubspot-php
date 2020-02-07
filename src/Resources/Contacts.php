<?php

namespace SevenShores\Hubspot\Resources;

/**
 * @see https://developers.hubspot.com/docs/methods/contacts/contacts-overview
 */
class Contacts extends Resource
{
    /**
     * Create a new contact.
     *
     * @param array $properties array of contact properties
     *
     * @return \SevenShores\Hubspot\Http\Response
     *
     * @see https://developers.hubspot.com/docs-beta/crm/contacts
     */
    public function create(array $properties)
    {
        $endpoint = 'https://api.hubapi.com/crm/v3/objects/contacts';

        return $this->client->request(
            'post',
            $endpoint,
            ['json' => ['properties' => $properties]]
        );
    }

	/**
	 * Batch create contacts.
	 *
	 * @see https://developers.hubspot.com/docs-beta/crm/contacts
	 *
	 * @param array $contacts the contacts and properties
	 *
	 * @return \SevenShores\Hubspot\Http\Response
	 */
	public function createBatch(array $contacts)
	{
		$endpoint = 'https://api.hubapi.com/crm/v3/objects/contacts/batch/create';

		return $this->client->request('post', $endpoint, ['json' => $contacts]);
	}

    /**
     * Update an existing contact.
     *
     * @param int   $id         the contact id
     * @param array $properties the contact properties to update
     *
     * @return \SevenShores\Hubspot\Http\Response
     *
     * @see https://developers.hubspot.com/docs-beta/crm/contacts
     */
    public function update($id, array $properties)
    {
        $endpoint = "https://api.hubapi.com/crm/v3/objects/contacts/{$id}";

        return $this->client->request(
            'patch',
            $endpoint,
            ['json' => ['properties' => $properties]]
        );
    }

	/**
	 * Update a group of existing contact records by their contactId.
	 *
	 * @see https://developers.hubspot.com/docs-beta/crm/deals
	 *
	 * @param array $contacts the contacts and properties
	 *
	 * @return \SevenShores\Hubspot\Http\Response
	 */
	public function updateBatch(array $contacts)
	{
		$endpoint = 'https://api.hubapi.com/crm/v3/objects/contacts/batch/update';

		return $this->client->request('post', $endpoint, ['json' => $contacts]);
	}

    /**
     * Update an existing contact by email.
     *
     * @param string $email      the contact's email address
     * @param array  $properties the contact properties to update
     *
     * @return \SevenShores\Hubspot\Http\Response
     *
     * @see https://developers.hubspot.com/docs/methods/contacts/update_contact-by-email
     */
    public function updateByEmail(string $email, array $properties)
    {
        $endpoint = "https://api.hubapi.com/contacts/v1/contact/email/{$email}/profile";

        return $this->client->request(
            'post',
            $endpoint,
            ['json' => ['properties' => $properties]]
        );
    }

    /**
     * Create or update a contact.
     *
     * @param string $email      the contact's email address
     * @param array  $properties the contact properties
     *
     * @return \SevenShores\Hubspot\Http\Response
     *
     * @see https://developers.hubspot.com/docs/methods/contacts/create_or_update
     */
    public function createOrUpdate(string $email, array $properties = [])
    {
        $endpoint = "https://api.hubapi.com/contacts/v1/contact/createOrUpdate/email/{$email}";

        return $this->client->request(
            'post',
            $endpoint,
            ['json' => ['properties' => $properties]]
        );
    }

    /**
     * Create or update a group of contacts.
     *
     * @param array $contacts the contacts and properties
     * @param array $params   Array of optional parameters ['auditId']
     *
     * @return \SevenShores\Hubspot\Http\Response
     *
     * @see https://developers.hubspot.com/docs/methods/contacts/batch_create_or_update
     */
    public function createOrUpdateBatch(array $contacts, array $params = [])
    {
        $endpoint = 'https://api.hubapi.com/contacts/v1/contact/batch';

        return $this->client->request(
            'post',
            $endpoint,
            ['json' => $contacts],
            build_query_string($params)
        );
    }

	/**
	 * Archive a contact.
	 *
	 * @param int $id
	 *
	 * @return \SevenShores\Hubspot\Http\Response
	 *
	 * @see https://developers.hubspot.com/docs-beta/crm/contacts
	 */
	public function archive($id)
	{
		$endpoint = "https://api.hubapi.com/crm/v3/objects/contacts/{$id}";

		return $this->client->request('delete', $endpoint);
	}

    /**
     * Delete a contact.
     *
     * @deprecated See 'archive' instead.
     * @param int $id
     *
     * @return \SevenShores\Hubspot\Http\Response
     *
     * @see https://developers.hubspot.com/docs-beta/crm/contacts
     */
    public function delete($id)
    {
        return $this->archive($id);
    }

    /**
     * For a given portal, return all contacts that have been created in the portal.
     *
     * A paginated list of contacts will be returned to you, with a maximum of 100 contacts per page.
     *
     * @see https://developers.hubspot.com/docs-beta/crm/contacts
     *
     * @param array $params Array of optional parameters ['limit', 'after', 'properties', 'associations', 'archived']
     *
     * @return \SevenShores\Hubspot\Http\Response
     */
    public function all(array $params = [])
    {
        $endpoint = 'https://api.hubapi.com/crm/v3/objects/contacts';

        return $this->client->request(
            'get',
            $endpoint,
            [],
            build_query_string($params)
        );
    }

    /**
     * For a given portal, return all contacts that have been recently updated or created.
     * A paginated list of contacts will be returned to you, with a maximum of 100 contacts per page, as specified by
     * the "count" parameter. The endpoint only scrolls back in time 30 days.
     *
     * @see https://developers.hubspot.com/docs/methods/contacts/get_recently_updated_contacts
     *
     * @param array $params Array of optional parameters ['count', 'timeOffset', 'vidOffset', 'property',
     *                      'propertyMode', 'formSubmissionMode', 'showListMemberships']
     *
     * @return \SevenShores\Hubspot\Http\Response
     */
    public function recent(array $params = [])
    {
        $endpoint = 'https://api.hubapi.com/contacts/v1/lists/recently_updated/contacts/recent';

        return $this->client->request(
            'get',
            $endpoint,
            [],
            build_query_string($params)
        );
    }

    /**
     * For a given portal, return all contacts that have been recently created.
     * A paginated list of contacts will be returned to you, with a maximum of 100 contacts per page, as specified by
     * the "count" parameter. The endpoint only scrolls back in time 30 days.
     *
     * @see https://developers.hubspot.com/docs/methods/contacts/get_recently_updated_contacts
     *
     * @param array $params Array of optional parameters ['count', 'timeOffset', 'vidOffset', 'property',
     *                      'propertyMode', 'formSubmissionMode', 'showListMemberships']
     *
     * @return \SevenShores\Hubspot\Http\Response
     */
    public function recentNew(array $params = [])
    {
        $endpoint = 'https://api.hubapi.com/contacts/v1/lists/all/contacts/recent';

        return $this->client->request(
            'get',
            $endpoint,
            [],
            build_query_string($params)
        );
    }

    /**
     * Get a contact by id
     *
     * @param int   $id
     * @param array $params Array of optional parameters ['properties' 'associations', 'archived']
     *
     * @return \SevenShores\Hubspot\Http\Response
     *
     * @see https://developers.hubspot.com/docs-beta/crm/contacts
     */
    public function getById($id, array $params = [])
    {
        $endpoint = "https://api.hubapi.com/crm/v3/objects/contacts/{$id}";

        return $this->client->request(
            'get',
            $endpoint,
            [],
            build_query_string($params)
        );
    }

    /**
     * For a given portal, return information about a group of contacts by their unique ID's. A contact's unique ID's
     * is stored in a field called 'vid' which stands for 'visitor ID'.
     *
     * This method will also return you much of the HubSpot lead "intelligence" for each requested contact record. The
     * endpoint accepts many query parameters that allow for customization based on a variety of integration use cases.
     *
     * @see https://developers.hubspot.com/docs-beta/crm/contacts
     *
     * @param array $ids   Array of visitor IDs
     * @param array $params Array of optional parameters ['properties', 'archived']
     *
     * @return \SevenShores\Hubspot\Http\Response
     */
    public function getBatchByIds(array $ids, array $params = [])
    {
        $endpoint = 'https://api.hubapi.com/crm/v3/objects/contacts/batch/read';

	    $params['inputs'] = array_map( function ( $id ) {
		    return [ 'id' => $id ];
	    }, $ids );

        return $this->client->request(
            'get',
            $endpoint,
            [],
            build_query_string($params)
        );
    }

    /**
     * Get a contact by email address.
     *
     * @param array $params Array of optional parameters ['property', 'propertyMode', 'formSubmissionMode',
     *                      'showListMemberships']
     *
     * @return \SevenShores\Hubspot\Http\Response
     *
     * @see https://developers.hubspot.com/docs/methods/contacts/get_contact_by_email
     */
    public function getByEmail(string $email, array $params = [])
    {
        $endpoint = "https://api.hubapi.com/contacts/v1/contact/email/{$email}/profile";

        return $this->client->request(
            'get',
            $endpoint,
            [],
            build_query_string($params)
        );
    }

    /**
     * For a given portal, return information about a group of contacts by their email addresses.
     *
     * This method will also return you much of the HubSpot lead "intelligence" for each requested contact record. The
     * endpoint accepts many query parameters that allow for customization based on a variety of integration use cases.
     *
     * @see https://developers.hubspot.com/docs/methods/contacts/get_batch_by_email
     *
     * @param array $emails Array of email adresses
     * @param array $params Array of optional parameters ['property', 'propertyMode', 'formSubmissionMode',
     *                      'showListMemberships', 'includeDeletes']
     *
     * @return \SevenShores\Hubspot\Http\Response
     */
    public function getBatchByEmails($emails, array $params = [])
    {
        $endpoint = 'https://api.hubapi.com/contacts/v1/contact/emails/batch/';

        $params['email'] = $emails;

        return $this->client->request(
            'get',
            $endpoint,
            [],
            build_query_string($params)
        );
    }

    /**
     * Get a contact by its user token.
     *
     * @param array $params Array of optional parameters ['property', 'propertyMode', 'formSubmissionMode',
     *                      'showListMemberships']
     *
     * @return \SevenShores\Hubspot\Http\Response
     *
     * @see https://developers.hubspot.com/docs/methods/contacts/get_contact_by_utk
     */
    public function getByToken(string $utk, array $params = [])
    {
        $endpoint = "https://api.hubapi.com/contacts/v1/contact/utk/{$utk}/profile";

        return $this->client->request(
            'get',
            $endpoint,
            [],
            build_query_string($params)
        );
    }

    /**
     * For a given portal, return information about a group of contacts by their user tokens (hubspotutk).
     *
     * This method will also return you much of the HubSpot lead "intelligence" for each requested contact
     * record. The endpoint accepts many query parameters that allow for customization based on a variety of
     * integration use cases.
     *
     * The endpoint does not allow for CORS, so if you are looking up contacts from their user token on the client,
     * you'll need to spin up a proxy server to interact with the API.
     *
     * @see https://developers.hubspot.com/docs/methods/contacts/get_batch_by_utk
     *
     * @param array $utks   Array of hubspot user tokens (hubspotutk)
     * @param array $params Array of optional parameters ['property', 'propertyMode', 'formSubmissionMode',
     *                      'showListMemberships', 'includeDeletes']
     *
     * @return \SevenShores\Hubspot\Http\Response
     */
    public function getBatchByTokens(array $utks, array $params = [])
    {
        $endpoint = 'https://api.hubapi.com/contacts/v1/contact/utks/batch/';

        $params['utk'] = $utks;

        return $this->client->request(
            'get',
            $endpoint,
            [],
            build_query_string($params)
        );
    }

    /**
     * For a given portal, return contacts and some data associated with
     * those contacts by the contact's email address or name.
     *
     * Please note that you should expect this method to only return a small
     * subset of data about the contact. One piece of data that the method will
     * return is the contact ID (vid) that you can then use to look up much
     * more data about that particular contact by its ID.
     *
     * @see https://developers.hubspot.com/docs/methods/contacts/search_contacts
     *
     * @param string $query  Search query
     * @param array  $params Array of optional parameters ['count', 'offset']
     *
     * @return \SevenShores\Hubspot\Http\Response
     */
    public function search(string $query, array $params = [])
    {
        $endpoint = 'https://api.hubapi.com/contacts/v1/search/query';

        $params['q'] = $query;

        return $this->client->request(
            'get',
            $endpoint,
            [],
            build_query_string($params)
        );
    }

    /**
     * @return \SevenShores\Hubspot\Http\Response
     */
    public function statistics()
    {
        $endpoint = 'https://api.hubapi.com/contacts/v1/contacts/statistics';

        return $this->client->request('get', $endpoint);
    }

    /**
     * Merge two contact records. The contact ID in the URL will be treated as the
     * primary contact, and the contact ID in the request body will be treated as
     * the secondary contact.
     *
     * @param int $id         primary contact id
     * @param int $vidToMerge contact ID of the secondary contact
     *
     * @return \SevenShores\Hubspot\Http\Response
     *
     * @see https://developers.hubspot.com/docs/methods/contacts/merge-contacts
     */
    public function merge($id, $vidToMerge)
    {
        $endpoint = "https://api.hubapi.com/contacts/v1/contact/merge-vids/{$id}/";

        return $this->client->request(
            'post',
            $endpoint,
            ['json' => ['vidToMerge' => $vidToMerge]]
        );
    }

    /**
     * Get Lifecycle Stage metrics for Contacts.
     *
     * @see https://developers.hubspot.com/docs/methods/contacts/get-lifecycle-stage-metrics-for-contacts
     *
     * @return \SevenShores\Hubspot\Http\Response
     */
    public function getLifecycleStageMetrics(array $params = [])
    {
        $endpoint = 'https://api.hubapi.com/contacts/v1/contacts/statistics';

        return $this->client->request(
            'get',
            $endpoint,
            [],
            build_query_string($params)
        );
    }
}
