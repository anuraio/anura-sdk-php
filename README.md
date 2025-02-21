# Anura SDK for PHP
The **Anura SDK for PHP** makes it easy for developers to access Anura Direct within their PHP code, and begin analyzing their traffic. You can get started in minutes by installing the SDK with Composer, or by downloading a single zip or phar file from our latest release.

## Getting Started
1. **Have an open active account with Anura** - You can see more about Anura's offerings [here.](https://www.anura.io/product#plans-pricing)
2. **Minimum Requirements** - To use the SDK, you will need **PHP >=7.4**.
- If you're looking to install the SDK *without* Composer, see the [**Alternative Installation Methods**](#alternative-installation-methods) section below.
3. **Install the SDK** - Using [Composer](https://getcomposer.org/) is the easiest and recommended way to install it. The SDK is available on Packagist. If Composer is installed globally on your system, you can run the following command in the base directory of your project to add the SDK as a dependency:
```
composer require anura/anura-sdk-php
```
4. **Using the SDK** - The best way to start getting familiar with the SDK is to have a look at our [**Quick Examples**](#quick-examples) section which covers the most common use-cases for it.

## Alternative Installation Methods
### Installing via PHAR
1. Download the PHAR from our latest release, and place it within your project.
2. Require or include the `anura-sdk-php.phar` file within your project.
3. You're good to go!

### Installing via ZIP Archive
1. Download `anura-sdk-php.zip` from our latest release, extract it, and place `anura-sdk-php/` within your project.
2. Require or include our autoloader at `anura-sdk-php/autoload.php`
3. You're good to go!

## Quick Examples

### Create the Anura Direct client
```php
// Require the Composer autoloader.
require 'vendor/autoload.php';

// Or if you're using the PHAR, require/include that.
require '/path/to/anura-sdk-php.phar';

// Or if you're using the ZIP archive, require/include its autoloader.
require '/path/to/anura-sdk-php/autoload.php';

use Anura\AnuraDirect;
use Anura\DirectRequestBuilder;
use Anura\DirectRequest;
use Anura\AdditionalData;
use Anura\DirectResult;
use Anura\Exception\AnuraClientException;
use Anura\Exception\AnuraServerException;

// Instantiate an Anura Direct client.
$direct = new AnuraDirect('your-instance-id-goes-here');
```

### Set additional data for Anura Direct
```php
/**
 * To send additional data to Anura Direct, use the AdditionalData class.
 * We will provide this object when calling $direct->getResult()
 */
$additionalData = new AdditionalData();
$additionalData->addElement(1, 'your-data-value');
```

### Updating elements of additional data
```php
/**
 * To update an element of additional data, 
 * simply add the element again but with a new value
 */
$indexToUpdate = 1;
$additionalData->addElement($indexToUpdate, 'your-new-data-value');
```

### Removing an element of additional data
```php
$indexToRemove = 1;
$additionalData->removeElement($indexToRemove);
```

### Create a DirectRequest object for AnuraDirect client
```php
$builder = new DirectRequestBuilder();
$request = $builder
                ->setIpAddress('visitors-ip-address')   // required
                ->setSource('your-source-value')        // optional
                ->setCampaign('your-campaign-value')    // optional
                ->setUserAgent('visitors-user-agent')   // optional
                ->setApp('visitors-app-id')             // optional
                ->setDevice('visitors-device-id')       // optional
                ->setAdditionalData($additionalData)    // optional
                ->build();
```

### Get a result from Anura Direct
```php
try {
    $result = $direct->getResult($request);
} catch (AnuraClientException $e) {
    // Handle 4XX responses here.
} catch (AnuraServerException $e) {
    // Handle 5XX responses here.
} catch (AnuraException $e) {
    /**
     * Handle any other exceptions that may have occurred.
     * Since AnuraClientException & AnuraServerException are children of AnuraException, 
     * feel free to remove those handling blocks if your handling logic is the same for both.
     */
}

// We got a result (a DirectResult object)! 
// See below for available properties & DirectResult objects.

// $result->isSuspect();
// $result->isNonSuspect();
// $result->isMobile();

// $anuraResult = $result->result;
// $visitorWasMobile = $result->mobile;
// $ruleSets = $result->ruleSets;
// $invalidTrafficType = $result->invalidTrafficType;

echo "result: $result";

```

## API Reference
### AnuraDirect
Can get results from Anura Direct. These results are fetched using Direct's `/direct.json` API endpoint.

#### Methods
**`getResult(DirectRequest $request): DirectResult`**
- Gets a result from Anura Direct.
- Exceptions thrown:
    - `AnuraClientException`: If a 4XX response is returned from Anura Direct.
    - `AnuraServerException`: If a 5XX response is returned from Anura Direct.
    - `AnuraException`: Base exception for the Anura SDK. Used for any unexpected exceptions caused when using the Anura SDK. Can also be used as a general catch-all exception for simpler error handling.

**`getInstance(): string`**
- Returns the instance you have set within the **`AnuraDirect`** client.

**`setInstance(string $instance): void`**
- Sets the instance of the **`AnuraDirect`** client to the `$instance` value passed.

### AdditionalData
A class representing Additional Data for Anura Direct. 

**`addElement(int $key, string $value): void`**
- Adds an element of data to your additional data.
- If you call `addElement()` multiple times with the same `$key`, the element at `$key` will simply be updated with the new `$value`.

**`removeElement(int $key): void`**
- Removes the element of additional data located at `$key`.
- Nothing will occur if you do not have a value stored at `$key`.

**`size(): int`**
- Returns the number of elements currently set within your additional data.

**`__toString(): string`**
- Returns your additional data as a JSON string.

### DirectRequestBuilder
A builder class for creating a `DirectRequest`.

**`build(): DirectRequest`**
- Builds and returns the `DirectRequest` as configured.

**`setSource(string $source): DirectRequestBuilder`**
- Sets the source for the `DirectRequest` to be built.

**`setCampaign(string $campaign): DirectRequestBuilder`**
- Sets the campaign for the `DirectRequest` to be built.

**`setIpAddress(string $ipAddress): DirectRequestBuilder`**
- Sets the IP address for the `DirectRequest` to be built. Both IPv4 and IPv6 addresses are supported.

**`setUserAgent(string $userAgent): DirectRequestBuilder`**
- Sets the user agent for the `DirectRequest` to be built.

**`setApp(string $app): DirectRequestBuilder`**
- Sets the application package identifier for the `DirectRequest` to be built.

**`setDevice(string $device): DirectRequestBuilder`**
- Sets the device identifier for the `DirectRequest` to be built.

**`setAdditionalData(AdditionalData $additionalData): DirectRequestBuilder`**
- Sets the additional data for the `DirectRequest` to be built.

### DirectRequest
An object that represents an Anura Direct API request.

**`getSource(): ?string`**
- Returns the source set within the `DirectRequest` instance.

**`setSource(string $source): void`**
- Sets the source of the `DirectRequest` instance to the `$source` value passed.

**`getCampaign(): ?string`**
- Returns the campaign set within the `DirectRequest` instance.

**`setCampaign(string $campaign): void`**
- Sets the campaign of the `DirectRequest` instance to the `$campaign` value passed.

**`getIpAddress(): string`**
- Returns the IP address set within the `DirectRequest` instance.

**`setIpAddress(string $ipAddress): void`**
- Sets the campaign of the `DirectRequest` instance to the `$ipAddress` value passed.

**`getUserAgent(): ?string`**
- Returns the user agent set within the `DirectRequest` instance.

**`setUserAgent(string $userAgent): void`**
- Sets the user agent of the `DirectRequest` instance to the `$userAgent` value passed.

**`getApp(): ?string`**
- Returns the application package identifier set within the `DirectRequest` instance.

**`setApp(string $app): void`**
- Sets the application package identifier of the `DirectRequest` instance to the `$app` value passed.

**`getDevice(): ?string`**
- Returns the device identifier set within the `DirectRequest` instance.

**`setDevice(string $device): void`**
- Sets the device identifier of the `DirectRequest` instance to the `$device` value passed.

**`getAdditionalData(): ?AdditionalData`**
- Returns the additional data set within the `DirectRequest` instance.

**`setAdditionalData(AdditionalData $additionalData): void`**
- Sets the additional data of the `DirectRequest` instance to the `$additionalData` passed.

### DirectResult
The result upon a successful call to `getResult()` from the **`AnuraDirect`** client. It contains not only the result from Anura Direct, but some other methods to help you use the result.

#### Methods
**`isSuspect(): bool`**
- Returns whether or not the visitor has been determined to be  **suspect**.

**`isNonSuspect(): bool`**
- Returns whether or not the visitor has been determined to be  **non-suspect**.

**`isMobile(): bool`**
- Returns whether or not the visitor has been determined to be on a mobile device.

**`getResult(): string`**
- Besides using our `isSuspect()` or `isNonSuspect()` methods, you are also able to access the result value.

**`getRuleSets(): ?array`**
- If you have **return rule sets** enabled, you will be able to see which specific rules were violated upon a **suspect** result. This value will be null if the visitor is **non-suspect**, or if you do not have **return rule sets** enabled.
- You can talk to [support](mailto:support@anura.io) about enabling or disabling the return rule sets feature.

**`getInvalidTrafficType: ?string`**
- If you have **return invalid traffic type** enabled, you will be able to access which type of invalid traffic occurred upon a **suspect** result.
- You can talk to [support](mailto:support@anura.io) about enabling or disabling the return invalid traffic type feature.