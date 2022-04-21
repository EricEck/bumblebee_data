<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Address
 *
 * @property int $id
 * @property string $street_1
 * @property string $street_2
 * @property string $street_3
 * @property string $city_name
 * @property string $postal_code
 * @property int $state_id
 * @property int $country_id
 * @property string $latitude
 * @property string $longitude
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Country|null $country
 * @property-read \App\Models\State|null $state
 * @method static \Illuminate\Database\Eloquent\Builder|Address newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Address newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Address query()
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereCityName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereStateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereStreet1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereStreet2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereStreet3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereUpdatedAt($value)
 */
	class Address extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BodiesOfWater
 *
 * @property int $id
 * @property int $pool_owner_id
 * @property string $name
 * @property string $description_pool
 * @property int $address_id
 * @property int $location_type_id
 * @property string $description_access
 * @property string $latitude
 * @property string $longitude
 * @property int $filtration_type_id
 * @property int $filteration_share_with_bow_id
 * @property int $construction_type_id
 * @property string $description_construction
 * @property string $construction_date
 * @property int $commercial
 * @property int $indoor
 * @property int $gallons
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Address|null $address
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BowComponentLocation[] $bowComponentLocations
 * @property-read int|null $bow_component_locations_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BowComponent[] $bowComponents
 * @property-read int|null $bow_components_count
 * @property-read \App\Models\ConstructionType|null $bowConstructionType
 * @property-read \App\Models\FiltrationType|null $bowFiltrationType
 * @property-read \App\Models\BowLocationType|null $bowLocationType
 * @property-read \App\Models\User|null $owner
 * @method static \Illuminate\Database\Eloquent\Builder|BodiesOfWater newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BodiesOfWater newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BodiesOfWater query()
 * @method static \Illuminate\Database\Eloquent\Builder|BodiesOfWater whereAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BodiesOfWater whereCommercial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BodiesOfWater whereConstructionDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BodiesOfWater whereConstructionTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BodiesOfWater whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BodiesOfWater whereDescriptionAccess($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BodiesOfWater whereDescriptionConstruction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BodiesOfWater whereDescriptionPool($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BodiesOfWater whereFilterationShareWithBowId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BodiesOfWater whereFiltrationTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BodiesOfWater whereGallons($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BodiesOfWater whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BodiesOfWater whereIndoor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BodiesOfWater whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BodiesOfWater whereLocationTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BodiesOfWater whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BodiesOfWater whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BodiesOfWater wherePoolOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BodiesOfWater whereUpdatedAt($value)
 */
	class BodiesOfWater extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BowComponent
 *
 * @property int $id
 * @property int $bodies_of_water_id
 * @property string $name
 * @property string $description
 * @property int $elliptic_product_id
 * @property int $manufacturer_id
 * @property int $installation_service_company_id
 * @property int $installation_service_ticket_id
 * @property string|null $installation_date
 * @property int $installation_location_id
 * @property int $installed_now
 * @property int $warranty
 * @property string|null $warranty_end_date
 * @property string $model_number
 * @property string $serial_number
 * @property string|null $removed_from_service_date
 * @property int $removed_from_service_ticket_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\BodiesOfWater|null $bodyOfWater
 * @property-read \App\Models\ComponentManufacturer|null $brand
 * @property-read \App\Models\BowComponentLocation|null $componentLocation
 * @property-read \App\Models\EllipticProduct|null $ellipticProduct
 * @method static \Illuminate\Database\Eloquent\Builder|BowComponent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BowComponent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BowComponent query()
 * @method static \Illuminate\Database\Eloquent\Builder|BowComponent whereBodiesOfWaterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BowComponent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BowComponent whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BowComponent whereEllipticProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BowComponent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BowComponent whereInstallationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BowComponent whereInstallationLocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BowComponent whereInstallationServiceCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BowComponent whereInstallationServiceTicketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BowComponent whereInstalledNow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BowComponent whereManufacturerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BowComponent whereModelNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BowComponent whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BowComponent whereRemovedFromServiceDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BowComponent whereRemovedFromServiceTicketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BowComponent whereSerialNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BowComponent whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BowComponent whereWarranty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BowComponent whereWarrantyEndDate($value)
 */
	class BowComponent extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BowComponentLocation
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $bodies_of_water_id
 * @property-read \App\Models\BodiesOfWater|null $bodyOfWater
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BowComponent[] $components
 * @property-read int|null $components_count
 * @method static \Illuminate\Database\Eloquent\Builder|BowComponentLocation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BowComponentLocation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BowComponentLocation query()
 * @method static \Illuminate\Database\Eloquent\Builder|BowComponentLocation whereBodiesOfWaterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BowComponentLocation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BowComponentLocation whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BowComponentLocation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BowComponentLocation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BowComponentLocation whereUpdatedAt($value)
 */
	class BowComponentLocation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BowLocationType
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|BowLocationType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BowLocationType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BowLocationType query()
 * @method static \Illuminate\Database\Eloquent\Builder|BowLocationType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BowLocationType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BowLocationType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BowLocationType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BowLocationType whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BowLocationType whereUpdatedAt($value)
 */
	class BowLocationType extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Bumblebee
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Bumblebee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bumblebee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bumblebee query()
 * @method static \Illuminate\Database\Eloquent\Builder|Bumblebee whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bumblebee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bumblebee whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $serial_number
 * @property string|null $manufactured_date
 * @property string|null $current_version
 * @property int|null $manufacturer_id
 * @property int|null $owner_id
 * @property int|null $install_id
 * @property string|null $assigned_to_owner_on
 * @property int $removed_from_service
 * @property string|null $api_password
 * @property string $remember_token
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\BumblebeeFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Bumblebee whereApiPassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bumblebee whereAssignedToOwnerOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bumblebee whereCurrentVersion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bumblebee whereInstallId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bumblebee whereManufacturedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bumblebee whereManufacturerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bumblebee whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bumblebee whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bumblebee whereRemovedFromService($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bumblebee whereSerialNumber($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Calibration[] $calibrations
 * @property-read int|null $calibrations_count
 * @property-read \App\Models\EllipticProduct|null $ellipticProduct
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Measurement[] $measurements
 * @property-read int|null $measurements_count
 * @property-read \App\Models\User|null $owner
 */
	class Bumblebee extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Calibration
 *
 * @property int $id
 * @property int $bumblebee_id
 * @property int $calibrator_id
 * @property string $calibration_type
 * @property string $metric
 * @property string $method
 * @property string $default_input_units
 * @property string $default_output_units
 * @property float $slope_m
 * @property float $offset_b
 * @property boolean $effective
 * @property \Illuminate\Support\Carbon $effective_timestamp
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Bumblebee|null $bumblebee
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Measurement[] $calibratedMeasurements
 * @property-read int|null $calibrated_measurements_count
 * @property-read \App\Models\User|null $calibrator
 * @method static \Illuminate\Database\Eloquent\Builder|Calibration newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Calibration newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Calibration query()
 * @method static \Illuminate\Database\Eloquent\Builder|Calibration whereBumblebeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Calibration whereCalibrationType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Calibration whereCalibratorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Calibration whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Calibration whereDefaultInputUnits($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Calibration whereDefaultOutputUnits($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Calibration whereEffective($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Calibration whereEffectiveTimestamp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Calibration whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Calibration whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Calibration whereMetric($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Calibration whereOffsetB($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Calibration whereSlopeM($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Calibration whereUpdatedAt($value)
 */
	class Calibration extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ComponentManufacturer
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 * @property string|null $website_main_url
 * @property string|null $website_service_url
 * @property int $is_elliptic_works
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ComponentManufacturer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ComponentManufacturer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ComponentManufacturer query()
 * @method static \Illuminate\Database\Eloquent\Builder|ComponentManufacturer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ComponentManufacturer whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ComponentManufacturer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ComponentManufacturer whereIsEllipticWorks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ComponentManufacturer whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ComponentManufacturer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ComponentManufacturer whereWebsiteMainUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ComponentManufacturer whereWebsiteServiceUrl($value)
 */
	class ComponentManufacturer extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ConstructionType
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ConstructionType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConstructionType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConstructionType query()
 * @method static \Illuminate\Database\Eloquent\Builder|ConstructionType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConstructionType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConstructionType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConstructionType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConstructionType whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConstructionType whereUpdatedAt($value)
 */
	class ConstructionType extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Country
 *
 * @property int $id
 * @property string $name
 * @property string $short_name
 * @property string $country_code
 * @property string $latitude
 * @property string $longitude
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\State[] $states
 * @property-read int|null $states_count
 * @method static \Illuminate\Database\Eloquent\Builder|Country newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Country newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Country query()
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereShortName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Country whereUpdatedAt($value)
 */
	class Country extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EllipticManufacturer
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $address_id
 * @property string $contact
 * @property string $phone_work
 * @property string $email_work
 * @property string $website_main_url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Address|null $address
 * @method static \Illuminate\Database\Eloquent\Builder|EllipticManufacturer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EllipticManufacturer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EllipticManufacturer query()
 * @method static \Illuminate\Database\Eloquent\Builder|EllipticManufacturer whereAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EllipticManufacturer whereContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EllipticManufacturer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EllipticManufacturer whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EllipticManufacturer whereEmailWork($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EllipticManufacturer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EllipticManufacturer whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EllipticManufacturer wherePhoneWork($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EllipticManufacturer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EllipticManufacturer whereWebsiteMainUrl($value)
 */
	class EllipticManufacturer extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EllipticMember
 *
 * @property int $id
 * @property int $user_id
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|EllipticMember newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EllipticMember newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EllipticMember query()
 * @method static \Illuminate\Database\Eloquent\Builder|EllipticMember whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EllipticMember whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EllipticMember whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EllipticMember whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EllipticMember whereUserId($value)
 */
	class EllipticMember extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EllipticModel
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 * @property int $is_bumblebee
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|EllipticModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EllipticModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EllipticModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|EllipticModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EllipticModel whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EllipticModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EllipticModel whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EllipticModel whereIsBumblebee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EllipticModel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EllipticModel whereUpdatedAt($value)
 */
	class EllipticModel extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EllipticProduct
 *
 * @property int $id
 * @property int $elliptic_model_id
 * @property string $serial_number
 * @property int $bumblebee_id
 * @property int $elliptic_manufacturer_id
 * @property string|null $manufactured_on
 * @property string $manufacture_construction_version
 * @property string $manufacture_software_version
 * @property string|null $warranty_started_on
 * @property string|null $warranty_ends_on
 * @property string $current_construction_version
 * @property string $current_software_version
 * @property int $installer_id
 * @property string|null $removed_from_service_on
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $pool_owner_id
 * @property int $bow_component_id
 * @property-read \App\Models\BodiesOfWater|null $bodyOfWater
 * @property-read \App\Models\BowComponent|null $bowComponent
 * @property-read \App\Models\Bumblebee|null $bumblebee
 * @property-read \App\Models\EllipticManufacturer|null $ellipticManufacturer
 * @property-read \App\Models\EllipticModel|null $ellipticModel
 * @property-read \App\Models\EllipticModel|null $model
 * @property-read \App\Models\User|null $owner
 * @method static \Illuminate\Database\Eloquent\Builder|EllipticProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EllipticProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EllipticProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder|EllipticProduct whereBowComponentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EllipticProduct whereBumblebeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EllipticProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EllipticProduct whereCurrentConstructionVersion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EllipticProduct whereCurrentSoftwareVersion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EllipticProduct whereEllipticManufacturerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EllipticProduct whereEllipticModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EllipticProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EllipticProduct whereInstallerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EllipticProduct whereManufactureConstructionVersion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EllipticProduct whereManufactureSoftwareVersion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EllipticProduct whereManufacturedOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EllipticProduct wherePoolOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EllipticProduct whereRemovedFromServiceOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EllipticProduct whereSerialNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EllipticProduct whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EllipticProduct whereWarrantyEndsOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EllipticProduct whereWarrantyStartedOn($value)
 */
	class EllipticProduct extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\FiltrationType
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|FiltrationType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FiltrationType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FiltrationType query()
 * @method static \Illuminate\Database\Eloquent\Builder|FiltrationType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FiltrationType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FiltrationType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FiltrationType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FiltrationType whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FiltrationType whereUpdatedAt($value)
 */
	class FiltrationType extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Measurement
 *
 * @property int $id
 * @property int $bumblebee_id
 * @property \Illuminate\Support\Carbon|null $measurement_timestamp
 * @property int $metric_sequence
 * @property string $metric
 * @property string $method
 * @property string|null $value
 * @property string|null $unit
 * @property string|null $details
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Measurement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Measurement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Measurement query()
 * @method static \Illuminate\Database\Eloquent\Builder|Measurement whereBumblebeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Measurement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Measurement whereDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Measurement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Measurement whereMeasurementTimestamp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Measurement whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Measurement whereMetric($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Measurement whereMetricSequence($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Measurement whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Measurement whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Measurement whereValue($value)
 * @mixin \Eloquent
 * @property string|null $process
 * @method static \Illuminate\Database\Eloquent\Builder|Measurement whereProcess($value)
 * @method static \Database\Factories\MeasurementFactory factory(...$parameters)
 * @property int $calibration_value
 * @method static \Illuminate\Database\Eloquent\Builder|Measurement whereCalibrationValue($value)
 * @property float $calibrated_value
 * @property string $calibrated_unit
 * @property int|null $calibration_id
 * @property int $bodies_of_water_id
 * @property-read \App\Models\BodiesOfWater|null $bodyOfWater
 * @property-read \App\Models\Bumblebee|null $bumblebee
 * @property-read \App\Models\Calibration|null $calibration
 * @method static \Illuminate\Database\Eloquent\Builder|Measurement whereBodiesOfWaterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Measurement whereCalibratedUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Measurement whereCalibratedValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Measurement whereCalibrationId($value)
 */
	class Measurement extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\OpenCage
 *
 * @method static \Illuminate\Database\Eloquent\Builder|OpenCage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OpenCage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OpenCage query()
 */
	class OpenCage extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Permission
 *
 * @property int $id
 * @property string $name
 * @property string|null $display_name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereUpdatedAt($value)
 */
	class Permission extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PoolMetrics
 *
 * @property int $id
 * @property int $bumblebee_id
 * @property int $measurement_id
 * @property string $pool_metric_timestamp
 * @property string $metric
 * @property float $metric_float_value
 * @property string $unit
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PoolMetrics newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PoolMetrics newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PoolMetrics query()
 * @method static \Illuminate\Database\Eloquent\Builder|PoolMetrics whereBumblebeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PoolMetrics whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PoolMetrics whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PoolMetrics whereMeasurementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PoolMetrics whereMetric($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PoolMetrics whereMetricFloatValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PoolMetrics wherePoolMetricTimestamp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PoolMetrics whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PoolMetrics whereUpdatedAt($value)
 */
	class PoolMetrics extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PoolOwner
 *
 * @property int $id
 * @property int $user_id
 * @property int $billing_same_as_address
 * @property int $billing_address_id
 * @property int $is_primary_owner
 * @property int $primary_owner_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Address|null $billingAddress
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BodiesOfWater[] $bodiesOfWater
 * @property-read int|null $bodies_of_water_count
 * @property-read \Illuminate\Database\Eloquent\Collection|PoolOwner[] $commonOwners
 * @property-read int|null $common_owners_count
 * @property-read \App\Models\User|null $primaryOwner
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|PoolOwner newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PoolOwner newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PoolOwner query()
 * @method static \Illuminate\Database\Eloquent\Builder|PoolOwner whereBillingAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PoolOwner whereBillingSameAsAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PoolOwner whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PoolOwner whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PoolOwner whereIsPrimaryOwner($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PoolOwner wherePrimaryOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PoolOwner whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PoolOwner whereUserId($value)
 */
	class PoolOwner extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Role
 *
 * @property int $id
 * @property string $name
 * @property string|null $display_name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereUpdatedAt($value)
 */
	class Role extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ServiceCompany
 *
 * @property int $id
 * @property string $name
 * @property int $address_primary_id
 * @property int $billing_same_as_address
 * @property int $address_billing_id
 * @property int $contact_primary_id
 * @property int $contact_billing_id
 * @property int $contact_technical_id
 * @property int $contact_service_id
 * @property string $phone_office
 * @property string $phone_fax
 * @property string $email_primary
 * @property string $website_url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Address|null $addressBilling
 * @property-read \App\Models\Address|null $addressPrimary
 * @property-read \App\Models\User|null $contactBilling
 * @property-read \App\Models\User|null $contactPrimary
 * @property-read \App\Models\User|null $contactService
 * @property-read \App\Models\User|null $contactTechnical
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Address[] $locations
 * @property-read int|null $locations_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $members
 * @property-read int|null $members_count
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCompany newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCompany newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCompany query()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCompany whereAddressBillingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCompany whereAddressPrimaryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCompany whereBillingSameAsAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCompany whereContactBillingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCompany whereContactPrimaryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCompany whereContactServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCompany whereContactTechnicalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCompany whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCompany whereEmailPrimary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCompany whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCompany whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCompany wherePhoneFax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCompany wherePhoneOffice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCompany whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCompany whereWebsiteUrl($value)
 */
	class ServiceCompany extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ServiceCompanyEmployee
 *
 * @property int $id
 * @property int $service_company_id
 * @property int $user_id
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ServiceCompany|null $serviceCompany
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCompanyEmployee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCompanyEmployee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCompanyEmployee query()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCompanyEmployee whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCompanyEmployee whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCompanyEmployee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCompanyEmployee whereServiceCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCompanyEmployee whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCompanyEmployee whereUserId($value)
 */
	class ServiceCompanyEmployee extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ServiceCompanyLocation
 *
 * @property int $id
 * @property int $service_company_id
 * @property int $address_id
 * @property int $active
 * @property string $name
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Address|null $address
 * @property-read \App\Models\ServiceCompany|null $serviceCompany
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCompanyLocation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCompanyLocation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCompanyLocation query()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCompanyLocation whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCompanyLocation whereAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCompanyLocation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCompanyLocation whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCompanyLocation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCompanyLocation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCompanyLocation whereServiceCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceCompanyLocation whereUpdatedAt($value)
 */
	class ServiceCompanyLocation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\State
 *
 * @property int $id
 * @property string $name
 * @property string $short_name
 * @property int $country_id
 * @property string $latitude
 * @property string $longitude
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Country|null $country
 * @method static \Illuminate\Database\Eloquent\Builder|State newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|State newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|State query()
 * @method static \Illuminate\Database\Eloquent\Builder|State whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|State whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|State whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|State whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|State whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|State whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|State whereShortName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|State whereUpdatedAt($value)
 */
	class State extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $phone_mobile
 * @property string $phone_home
 * @property string $phone_office
 * @property int $address_home_id
 * @property int $pool_owner_id
 * @property int $service_employee_id
 * @property int $elliptic_member_id
 * @property-read \App\Models\Address|null $addressHome
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BodiesOfWater[] $bodiesOfWater
 * @property-read int|null $bodies_of_water_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Bumblebee[] $bumblebees
 * @property-read int|null $bumblebees_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Calibration[] $calibrations
 * @property-read int|null $calibrations_count
 * @property-read \App\Models\EllipticMember|null $ellipticMember
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EllipticProduct[] $ellipticProducts
 * @property-read int|null $elliptic_products_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \App\Models\PoolOwner|null $poolOwner
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Illuminate\Database\Eloquent\Builder|User allUsersWithRoleIDs()
 * @method static \Illuminate\Database\Eloquent\Builder|User allUsersWithRoleNames()
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User orWherePermissionIs($permission = '')
 * @method static \Illuminate\Database\Eloquent\Builder|User orWhereRoleIs($role = '', $team = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User someUsers()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAddressHomeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDoesntHavePermission()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDoesntHaveRole()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEllipticMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePermissionIs($permission = '', $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhoneHome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhoneMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhoneOffice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePoolOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRoleIs($role = '', $team = null, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|User whereServiceEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

