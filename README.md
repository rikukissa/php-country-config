# PHP Country config boilerplate

This is not a boilerplate OpenCRVS officially maintains and supports.
It's purpose is to demonstrate that it is possible for a country to implement their own country config in the language of their choosing.

## Setup

1. Install MongoDB driver for PHP `sudo pecl install mongodb`
2. Install dependencies `php composer.phar update`
3. Run `./seed.sh` to create users and configuration from `seed/data`
4. Run `./start.sh`
5. The server should now be running in http://localhost:3040/

## What's included

- Provides basic configuration and translations for OpenCRVS
- Can validate created birth registrations and generate birth registration numbers

## What's still missing

- Database seeding. This means we would still need to implement:

  1. Script to clear all OpenCRVS database data [(reference)](https://github.com/opencrvs/opencrvs-farajaland/blob/develop/clear-all-data.sh)
  2. Script for adding default users, locations, form fields... to OpenCRVS database [(reference)](https://github.com/opencrvs/opencrvs-farajaland/blob/develop/db-populate.sh)
