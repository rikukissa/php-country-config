#! /bin/sh
set -e

for i in "$@"; do
  case $i in
    --path-to-core=*)
      PATH_TO_CORE="${i#*=}"
      shift
      ;;
    -*|--*)
      echo "Unknown option $i"
      exit 1
      ;;
    *)
      ;;
  esac
done

if [ -z $PATH_TO_CORE ]; then
  echo "Missing parameter: --path-to-core"
  echo "This is needed so that the seed script can run OpenCRVS Core migrations after seeding the database."
  echo
  print_usage_and_exit
fi

bash seed/clean-database.sh
php seed/seed.php
source $PATH_TO_CORE/packages/migration/runMigrations.sh $PATH_TO_CORE/packages/migration