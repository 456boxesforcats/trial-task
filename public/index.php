<?php

require_once '../vendor/autoload.php';

use App\Classes\Helpers\PropertyHelper;
use App\Classes\Repositories\PropertyDealTypeRepository;
use App\Classes\Repositories\PropertyTypeRepository;
use Dotenv\Dotenv;
use App\Classes\Repositories\PropertyRepository;

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$propertyRepository = new PropertyRepository();
$propertyTypeRepository = new PropertyTypeRepository();
$propertyDealTypeRepository = new PropertyDealTypeRepository();

$propertyTypes = $propertyTypeRepository->get();
$propertyDealTypes = $propertyDealTypeRepository->get();

// Filters defaults

$filters = [];

if (!empty($_GET['filter'])) {
    $filters['town'] = !empty($_GET['filter']['town']) ? $_GET['filter']['town'] : null;
    $filters['num_bedrooms'] = !empty($_GET['filter']['num_bedrooms']) ? (int)$_GET['filter']['num_bedrooms'] : null;
    $filters['min_price'] = !empty($_GET['filter']['min_price']) ? (float)$_GET['filter']['min_price'] : null;
    $filters['max_price'] = !empty($_GET['filter']['max_price']) ? (float)$_GET['filter']['max_price'] : null;
    $filters['property_type_id'] = !empty($_GET['filter']['property_type_id']) ? (int)$_GET['filter']['property_type_id'] : null;
    $filters['property_deal_type_id'] = !empty($_GET['filter']['property_deal_type_id']) ? (int)$_GET['filter']['property_deal_type_id'] : null;
}

// Pagination

$where = PropertyHelper::getFiltersWhere($filters);

$perPage = 30;
$recordsTotal = $propertyRepository->count($where);
$pageCount = ceil($recordsTotal / $perPage);
$currentPage = !empty($_GET['page']) && (int)$_GET['page'] <= $pageCount ? (int)$_GET['page'] : 1;

$properties = $propertyRepository->getWithRelations($perPage, ($currentPage - 1) * $perPage, $where);

?>

<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <title>Trial Task</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta property="og:title" content="">
    <meta property="og:type" content="">
    <meta property="og:url" content="">
    <meta property="og:image" content="">

    <link rel="stylesheet" href="css/style.css">
</head>

<body>
<div class="row">
    <div class="container">
        <form method="GET" class="form">
            <div class="fom-group">
                <label for="town">Town</label>
                <input type="text" name="filter[town]" id="town"
                       value="<?php echo !empty($filters['town']) ? $filters['town'] : '' ?>">
            </div>

            <div class="fom-group">
                <label for="num_bedrooms">Number of Bedrooms</label>
                <input type="number" name="filter[num_bedrooms]" id="num_bedrooms"
                       value="<?php echo !empty($filters['num_bedrooms']) ? $filters['num_bedrooms'] : '' ?>">
            </div>

            <div class="fom-group">
                <label for="min_price">Min Price</label>
                <input type="number" name="filter[min_price]" id="min_price"
                       value="<?php echo !empty($filters['min_price']) ? $filters['min_price'] : '' ?>">
            </div>

            <div class="fom-group">
                <label for="max_price">Max Price</label>
                <input type="number" name="filter[max_price]" id="max_price"
                       value="<?php echo !empty($filters['max_price']) ? $filters['max_price'] : '' ?>">
            </div>

            <div class="fom-group">
                <label for="property_type">Property Type</label>
                <select name="filter[property_type_id]" id="property_type">
                    <option value=""></option>
                    <?php foreach ($propertyTypes as $propertyType) { ?>
                        <option value="<?php echo $propertyType->id ?>"
                            <?php echo !empty($filters['property_type_id']) &&
                            $propertyType->id === $filters['property_type_id'] ? 'selected' : '' ?>>
                            <?php echo $propertyType->title ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="fom-group">
                <label for="property_deal_type">Property Deal Type</label>
                <select name="filter[property_deal_type_id]" id="property_deal_type">
                    <option value=""></option>
                    <?php foreach ($propertyDealTypes as $propertyDealType) { ?>
                        <option value="<?php echo $propertyDealType->id ?>"
                            <?php echo !empty($filters['property_deal_type_id']) &&
                            $propertyDealType->id === $filters['property_deal_type_id'] ? 'selected' : '' ?>>
                            <?php echo $propertyDealType->title ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <input type="submit" value="Filter">
            <input type="hidden" name="page" value="<?php echo $currentPage ?>">
        </form>
    </div>
</div>

<div class="row">
    <div class="container">
        <div class="pagination">
            <?php for ($pageNumber = 1; $pageNumber <= $pageCount; $pageNumber++) {
                $query = $_GET;
                $query['page'] = $pageNumber;
                $queryResult = http_build_query($query);
                ?>
                <a href="<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo $queryResult; ?>"
                   class="pagination--item <?php echo $pageNumber === $currentPage ? 'item-active' : '' ?>">
                    <?php echo $pageNumber ?>
                </a>
            <?php } ?>
        </div>
    </div>
</div>

<?php if (!empty($properties)) { ?>
    <table class="table">
        <thead>
        <tr>
            <th>Uuid</th>
            <th>Property Type</th>
            <th class="col-wide">Property Type description</th>
            <th>County</th>
            <th>Country</th>
            <th>Town</th>
            <th class="col-wide">Description</th>
            <th>Address</th>
            <th>Image Full</th>
            <th>Image Thumbnail</th>
            <th>Latitude</th>
            <th>Longitude</th>
            <th>Num Bedrooms</th>
            <th>Num Bathrooms</th>
            <th>Price</th>
            <th>Deal Type</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($properties as $property) { ?>
            <tr>
                <td><?php echo htmlspecialchars($property->uuid) ?></td>
                <td><?php echo htmlspecialchars($property->propertyType->title) ?></td>
                <td><?php echo htmlspecialchars($property->propertyType->description) ?></td>
                <td><?php echo htmlspecialchars($property->county) ?></td>
                <td><?php echo htmlspecialchars($property->country) ?></td>
                <td><?php echo htmlspecialchars($property->town) ?></td>
                <td><?php echo htmlspecialchars($property->description) ?></td>
                <td><?php echo htmlspecialchars($property->address) ?></td>
                <td><?php echo htmlspecialchars($property->imageFull) ?></td>
                <td><?php echo htmlspecialchars($property->imageThumbnail) ?></td>
                <td><?php echo $property->latitude ?></td>
                <td><?php echo $property->longitude ?></td>
                <td><?php echo $property->numBedrooms ?></td>
                <td><?php echo $property->numBathrooms ?></td>
                <td><?php echo $property->price ?></td>
                <td><?php echo htmlspecialchars($property->propertyDealType->title) ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

<?php } else { ?>
    <div class="row">
        <div class="container">No results</div>
    </div>
<?php } ?>
</body>

</html>
