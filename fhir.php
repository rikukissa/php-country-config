<?php
function findTaskIdentifier($bundle)
{
  $birthTrackingSystem = 'http://opencrvs.org/specs/id/birth-tracking-id';

  if ($bundle['resourceType'] === 'Bundle' && isset($bundle['entry'])) {
    foreach ($bundle['entry'] as $entry) {
      if (isset($entry['resource']['resourceType']) && $entry['resource']['resourceType'] === 'Task') {
        if (isset($entry['resource']['identifier']) && is_array($entry['resource']['identifier'])) {
          foreach ($entry['resource']['identifier'] as $identifier) {
            if (isset($identifier['system']) && $identifier['system'] === $birthTrackingSystem) {
              return $identifier['value'];
            }
          }
        }
      }
    }
  }

  return null;
}

function generateRandomString($length = 6)
{
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $charactersLength = strlen($characters);
  $randomString = '';

  for ($i = 0; $i < $length; $i++) {
    $randomString .= $characters[rand(0, $charactersLength - 1)];
  }

  return $randomString;
}
