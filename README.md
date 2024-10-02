# Anura SDK for PHP
The **Anura SDK for PHP** makes it easy for developers to access Anura Direct within their PHP code, and begin analyzing their traffic. You can get started in minutes by installing the SDK with Composer, or by downloading a single zip or phar file from our latest release.

## Getting Started
1. **Have an open active account with Anura** - You can see more about Anura's offerings [here.](https://www.anura.io/product#plans-pricing)
2. **Minimum Requirements** - To use the SDK, you will need **PHP >=7.4**.
3. **Install the SDK** - Using [Composer](https://getcomposer.org/) is the easiest and recommended way to install it. The SDK is available on Packagist. If Composer is installed globally on your system, you can run the following command in the base directory of your project to add the SDK as a dependency:
```
composer require anura/anura-sdk-php
```
4. **Using the SDK** - The best way to start getting familiar with the SDK is to have a look at our **Quick Examples** section which covers the most common use-cases for it.

## Quick Examples

### Create the Anura Direct client
```php
// Require the Composer autoloader.
require 'vendor/autoload.php';

use Anura\AnuraDirect;
use Anura\DirectResult;

// Instantiate an Anura Direct client.
$direct = new AnuraDirect('your-instance-id-goes-here');
```
### Set a custom source, campaign, and additional data for Anura Direct
```php
$direct->setSource('your-source-value');
$direct->setCampaign('your-campaign-value');
$direct->addAdditionalData('1', 'your-data-value');
```

### Updating additional data at a specific index
```php
/**
 * To update an element of additional data at a specific index, 
 * simply add the element again but with a new value.
 */
$indexToUpdate = '1';
$direct->addAdditionalData($indexToUpdate, 'your-new-data-value');
```

### Removing an element from additional data
```php
$indexToRemove = '1';
$direct->removeAdditionalData($indexToRemove);
```

### Get a result from Anura Direct
```php
$result = $direct->getResult(
    'visitors-ip-address',
    'visitors-user-agent', // optional
    'visitors-app-package-id', // optional
    'visitors-device-id' // optional
);

if ($result) {
    // We got a result (a DirectResult object)! 
    // See below for available properties & DirectResult objects.

    // $result->isSuspect();
    // $result->isNonSuspect();
    // $result->isMobile();

    // $anuraResult = $result->result;
    // $visitorWasMobile = result->mobile;
    // $ruleSets = $result->ruleSets;
    // $invalidTrafficType = $result->invalidTrafficType;

} else {
    // An error occurred. Can retrieve the error message using getError().
    $error = $direct->getError();

    // Error handling logic goes here.
}
```

## API Reference
### AnuraDirect
Can get results from Anura Direct. These results are fetched using Direct's `/direct.json` API endpoint.

#### Methods
**`getResult(): ?DirectResult`**
- Gets a result from Anura Direct. Returns `null` if an error was received from Anura Direct. The error can be recieved by calling `getError()`.

Parameters:

| Name | Type | Description | Required |
| ---- | ---- | ----------- | -------- |
| `$ipAddress` | `string` | The IP address of your visitor. Both IPv4 & IPv6 addresses are supported. | Yes |
| `$userAgent` | `string` | The user agent string of your visitor | |
| `$app` | `string` | The application package identifier of your visitor (when available.) | |
| `$device` | `string` | The device identifier of your visitor (when available.) | |
  
**`getError(): ?string`**
- Returns the last received error from Anura Direct. Returns null if an error has not occurred.

**`getInstance(): string`**
- Returns the instance you have set within the **`AnuraDirect`** client.

**`getSource(): string`**
- Returns the source you have set within the **`AnuraDirect`** client.

**`getCampaign(): string`**
- Returns the source you have set within the **`AnuraDirect`** client.

**`getAdditionalData(): array`**
- Returns the addtional data you have set within the **`AnuraDirect`** client.

**`setInstance(string $instance): string`**
- Sets the instance ID of the **`AnuraDirect`** client to the `$instance` value passed.

**`setSource(string $source): string`**
- Sets the source of the **`AnuraDirect`** client to the `$source` value passed.

**`setCampaign(string $campaign): string`**
- Sets the campaign of the **`AnuraDirect`** client to the `$campaign` value passed.

**`addAdditionalData(string $key, string $value): void`**
- Adds an element of additional data to be sent to Anura Direct. 
- If you call `addAdditionalData()` multiple times with the same `$key`, the element at `$key` will simply be updated with the new `$value`.

**`removeAdditionalData(string $key): void`**
- Removes an element of your additional data array which will be sent to Anura Direct.
- Nothing will occur if you do not have a value stored at `$key`.

### DirectResult
The result upon a successful call to `getResult()` from the **`AnuraDirect`** client. It contains not only the result from Anura Direct, but some other methods to help you use the result.

#### Methods
**`isSuspect(): bool`**
- Returns whether or not the visitor has been determined to be  **suspect**.

**`isNonSuspect(): bool`**
- Returns whether or not the visitor has been determined to be  **non-suspect**.

**`isMobile(): bool`**
- Returns whether or not the visitor has been determined to be on a mobile device.

#### Properties
**`result: string`**
- Besides using our `isSuspect()` or `isNonSuspect()` methods, you are also able to access the result value.

**`ruleSets: ?array`**
- If you have **return rule sets** enabled, you will be able to see which specific rules were violated upon a **suspect** result. This value will be null if the visitor is **non-suspect**, or if you do not have **return rule sets** enabled.
- You can talk to [support](mailto:support@anura.io) about enabling or disabling the return rule sets feature.
 
**`invalidTrafficType: ?string`**
- If you have **return invalid traffic type** enabled, you will be able to access which type of invalid traffic occurred upon a **suspect** result.
- You can talk to [support](mailto:support@anura.io) about enabling or disabling the return invalid traffic type feature.