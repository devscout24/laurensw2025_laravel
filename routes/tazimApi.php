<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\tazimApi\FAQControllerApi;
use App\Http\Controllers\API\tazimApi\RatingApiController;
use App\Http\Controllers\API\tazimApi\GalleryControllerApi;
use App\Http\Controllers\API\tazimApi\MissionApiController;
use App\Http\Controllers\API\tazimApi\HomeTourControllerApi;
use App\Http\Controllers\API\tazimApi\OurStoryApiController;
use App\Http\Controllers\API\tazimApi\SeoTitleApiController;
use App\Http\Controllers\API\tazimApi\SettingsApiController;
use App\Http\Controllers\API\tazimApi\ShipViewApiController;
use App\Http\Controllers\API\tazimApi\ShipDecksApiController;
use App\Http\Controllers\API\tazimApi\TranslateApiController;
use App\Http\Controllers\API\tazimApi\GetInTouchApiController;
use App\Http\Controllers\API\tazimApi\HomeBannerControllerApi;
use App\Http\Controllers\API\tazimApi\ShipCabinsApiController;
use App\Http\Controllers\API\tazimApi\UserSigninApiController;
use App\Http\Controllers\API\tazimApi\BookingTripApiController;
use App\Http\Controllers\API\tazimApi\CompanyInfoApiController;
use App\Http\Controllers\API\tazimApi\DynamicPageApiController;
use App\Http\Controllers\API\tazimApi\HeadingTitleApiController;
use App\Http\Controllers\API\tazimApi\SubscriptionApiController;
use App\Http\Controllers\API\tazimApi\GoogleSnippetApiController;
use App\Http\Controllers\API\tazimApi\ShipAmenitiesApiController;
use App\Http\Controllers\API\tazimApi\TravelAdvisorControllerApi;
use App\Http\Controllers\API\tazimApi\UniqueFeaturesApiController;
use App\Http\Controllers\API\tazimApi\HomePageMetaTagApiController;
use App\Http\Controllers\API\tazimApi\ShipPageMetaTagApiController;
use App\Http\Controllers\API\tazimApi\WhyTravelWithUsApiController;
use App\Http\Controllers\API\tazimApi\AboutPageMetaTagApiController;
use App\Http\Controllers\API\tazimApi\PeopleBehindTripApiController;
use App\Http\Controllers\API\tazimApi\DynamicTripButtonApiController;
use App\Http\Controllers\API\tazimApi\NaturePageMetaTagApiController;
use App\Http\Controllers\API\tazimApi\PopularNatureTourControllerApi;
use App\Http\Controllers\API\tazimApi\ResponsibleTravelApiController;
use App\Http\Controllers\API\tazimApi\ContactPageMetaTagApiController;
use App\Http\Controllers\API\tazimApi\DestinationWeCoverApiController;
use App\Http\Controllers\API\tazimApi\TermCondtPageMetaTagApiController;
use App\Http\Controllers\API\tazimApi\TermsConditionBannerApiController;
use App\Http\Controllers\API\tazimApi\ExploreAllNatureBannerApiController;
use App\Http\Controllers\API\tazimApi\ContactPolarTravelerBannerApiController;
use App\Http\Controllers\API\tazimApi\HomeExperienceSectionImagesControllerApi;
use App\Http\Controllers\API\tazimApi\ExploreNatureTravelWithBannerApiController;
use App\Http\Controllers\API\tazimApi\ExploreFinnishWildernessBannerApiController;
use App\Http\Controllers\API\tazimApi\NtrTripExploreFinnishWildernessBannerApiController;
use App\Http\Controllers\API\tazimApi\ShipNtrTripExploreFinnishWildernessBannerApiController;

Route::middleware('auth:api')->group(function () {

    Route::controller(BookingTripApiController::class)->group(function () {
        Route::get('/bookingTripApi/index', 'index')->name('bookingTripApi.index');
        Route::post('/bookingTripApi/store', 'store')->name('bookingTripApi.store');
        // Route::get('/bookingTripApi/bookingList', 'bookingList')->name('bookingTripApi.bookingList');
    });

    Route::controller(UserSigninApiController::class)->group(function () {
        Route::post('/userSigninApi/logout', 'logout')->name('userSigninApi.logout');
        Route::get('/userSigninApi/edit', 'edit')->name('userSigninApi.edit');
        Route::post('/userSigninApi/update', 'update')->name('userSigninApi.update');
        Route::post('/userSigninApi/resetPassword', 'resetPassword')->name('userSigninApi.resetPassword');
        Route::delete('/userSigninApi/delete', 'delete')->name('userSigninApi.delete');
    });

});

Route::controller(PeopleBehindTripApiController::class)->group(function () {
    Route::get('/peopleBehindApi/index', 'index')->name('peopleBehindApi.index');
    Route::get('/peopleBehindApi/header', 'header')->name('peopleBehindApi.header');
});

Route::controller(MissionApiController::class)->group(function () {
    Route::get('/missionApi/index', 'index')->name('missionApi.index');
});

Route::controller(OurStoryApiController::class)->group(function () {
    Route::get('/ourstoryApi/index', 'index')->name('ourstoryApi.index');
});

Route::controller(GetInTouchApiController::class)->group(function () {
    Route::post('/getInTouchApi/store', 'store')->name('getInTouchApi.store');
    // Route::post('/getInTouchApi/store2', 'store2')->name('getInTouchApi.store2');
});

Route::controller(UserSigninApiController::class)->group(function () {
    Route::post('/userSigninApi/register', 'register')->name('userSigninApi.register');
    Route::post('/userSigninApi/login', 'login')->name('userSigninApi.login');

    Route::post('/forgetPass/sendOtp', 'sendOtp')->name('forgetPass.sendOtp');
    Route::post('/forgetPass/verifyOtp', 'verifyOtp')->name('forgetPass.verifyOtp');
    Route::post('/forgetPass/forgetResetPass', 'forgetResetPass')->name('forgetPass.forgetResetPass');
});

Route::controller(UniqueFeaturesApiController::class)->group(function () {
    Route::get('/uniqueFeaturesApi/index', 'index')->name('uniqueFeaturesApi.index');
    Route::get('/uniqueFeaturesApi/header', 'header')->name('uniqueFeaturesApi.header');
});

Route::controller(ResponsibleTravelApiController::class)->group(function () {
    Route::get('/responsibleTravelApi/index', 'index')->name('responsibleTravelApi.index');
});

Route::controller(RatingApiController::class)->group(function () {
    Route::get('/ratingApi/index', 'index')->name('ratingApi.index');
    Route::get('/ratingApi/header', 'header')->name('ratingApi.header');
    Route::get('/ratingApi/calculate', 'calculate')->name('ratingApi.calculate');
});

Route::controller(HeadingTitleApiController::class)->group(function () {
    Route::get('/headingTitleApi/index', 'index')->name('headingTitleApi.index');
});

Route::controller(DestinationWeCoverApiController::class)->group(function () {
    Route::get('/destinationCoverApi/index', 'index')->name('destinationCoverApi.index');
    Route::get('/destinationCoverApi/header', 'header')->name('destinationCoverApi.header');
});

Route::controller(SeoTitleApiController::class)->group(function () {
    Route::get('/seoTitleApi/index', 'index')->name('seoTitleApi.index');
});

Route::controller(WhyTravelWithUsApiController::class)->group(function () {
    Route::get('/whyTravelWithUsapi/allInclusive', 'index1')->name('whyTravelWithUsapi.allInclusive');
    Route::get('/whyTravelWithUsapi/premiumService', 'index2')->name('whyTravelWithUsapi.premiumService');
    Route::get('/whyTravelWithUsapi/header', 'header')->name('whyTravelWithUsapi.header');
});

Route::controller(DynamicTripButtonApiController::class)->group(function () {
    Route::get('/dynamicTripButtonApi/index', 'index')->name('dynamicTripButtonApi.index');
});

Route::controller(HomeBannerControllerApi::class)->group(function () {
    Route::get('/homeBannerApi/index', 'index')->name('homeBannerApi.index');
});

Route::controller(HomeTourControllerApi::class)->group(function () {
    Route::get('/homeTourApi/index', 'index')->name('homeTourApi.index');
});

Route::controller(HomeExperienceSectionImagesControllerApi::class)->group(function () {
    Route::get('/homeExperienceImageSectionApi/index', 'index')->name('homeExperienceImageSectionApi.index');
    Route::get('/homeExperienceImageSectionApi/header', 'header')->name('homeExperienceImageSectionApi.header');
});

Route::controller(FAQControllerApi::class)->group(function () {
    Route::get('/faqApi/index', 'index')->name('faqApi.index');
});

Route::controller(PopularNatureTourControllerApi::class)->group(function () {
    Route::get('/popularNatureTourApi/index', 'index')->name('popularNatureTourApi.index');
});

Route::controller(GalleryControllerApi::class)->group(function () {
    Route::get('/galleryApi/index', 'index')->name('galleryApi.index');
    Route::get('/galleryApi/header', 'header')->name('galleryApi.header');
});

Route::controller(TravelAdvisorControllerApi::class)->group(function () {
    Route::get('/travelAdvisorApi/index', 'index')->name('travelAdvisorApi.index');
});

// Route::controller(SinglePageBannerControllerApi::class)->group(function () {
//     Route::get('/singlePageBannerApi/index', 'index')->name('singlePageBanner.index');

//     Route::get('/singlePageBannerApi/banner1', 'banner1')->name('singlePageBanner.banner1');
//     Route::get('/singlePageBannerApi/banner2', 'banner2')->name('singlePageBanner.banner2');
//     Route::get('/singlePageBannerApi/banner3', 'banner3')->name('singlePageBanner.banner3');
//     Route::get('/singlePageBannerApi/banner4', 'banner4')->name('singlePageBanner.banner4');
//     Route::get('/singlePageBannerApi/banner5', 'banner5')->name('singlePageBanner.banner5');
//     Route::get('/singlePageBannerApi/banner6', 'banner6')->name('singlePageBanner.banner6');
//     Route::get('/singlePageBannerApi/banner7', 'banner7')->name('singlePageBanner.banner7');
//     Route::get('/singlePageBannerApi/banner8', 'banner8')->name('singlePageBanner.banner8');
//     Route::get('/singlePageBannerApi/banner9', 'banner9')->name('singlePageBanner.banner9');
//     Route::get('/singlePageBannerApi/banner10', 'banner10')->name('singlePageBanner.banner10');
//     Route::get('/singlePageBannerApi/banner11', 'banner11')->name('singlePageBanner.banner11');
//     Route::get('/singlePageBannerApi/banner12', 'banner12')->name('singlePageBanner.banner12');
// });

Route::controller(DynamicPageApiController::class)->group(function () {
    Route::get('/dynamicPage/index', 'index')->name('dynamicPage.index');
    Route::get('/dynamicPage/show/{slug}', 'show')->name('dynamicPage.show');
});

Route::controller(ContactPolarTravelerBannerApiController::class)->group(function () {
    Route::get('/contactPolTrvlBanApi/index', 'index')->name('contactPolTrvlBanApi.index');
});

Route::controller(ExploreAllNatureBannerApiController::class)->group(function () {
    Route::get('/exploreAllNatBanApi/index', 'index')->name('exploreAllNatBanApi.index');
});

Route::controller(ExploreFinnishWildernessBannerApiController::class)->group(function () {
    Route::get('/exploreFinWildBanApi/index', 'index')->name('exploreFinWildBanApi.index');
});

Route::controller(ExploreNatureTravelWithBannerApiController::class)->group(function () {
    Route::get('/exploreNatTrvlWitBanApi/index', 'index')->name('exploreNatTrvlWitBanApi.index');
});

Route::controller(NtrTripExploreFinnishWildernessBannerApiController::class)->group(function () {
    Route::get('/ntrTripExpFinWitBanApi/index', 'index')->name('ntrTripExpFinWitBanApi.index');
});

Route::controller(ShipNtrTripExploreFinnishWildernessBannerApiController::class)->group(function () {
    Route::get('/shipPageBanApi/index', 'index')->name('shipPageBanApi.index');
});

// Route::controller(ShipDetailNtrTripExploreFinnishWildernessBannerApiController::class)->group(function () {
//     Route::get('/shipDetailsBan/index', 'index')->name('shipDetailsBan.index');
// });

Route::controller(TermsConditionBannerApiController::class)->group(function () {
    Route::get('/termsConditionBanApi/index', 'index')->name('termsConditionBanApi.index');
});

Route::controller(HomePageMetaTagApiController::class)->group(function () {
    Route::get('/homePageMetaTagApi/index', 'index')->name('homePageMetaTagApi.index');
});

Route::controller(NaturePageMetaTagApiController::class)->group(function () {
    Route::get('/naturePageMetaTagApi/index', 'index')->name('naturePageMetaTagApi.index');
});

Route::controller(AboutPageMetaTagApiController::class)->group(function () {
    Route::get('/aboutPageMetaTagApi/index', 'index')->name('aboutPageMetaTagApi.index');
});

Route::controller(ContactPageMetaTagApiController::class)->group(function () {
    Route::get('/contactPageMetaTagApi/index', 'index')->name('contactPageMetaTagApi.index');
});

Route::controller(TermCondtPageMetaTagApiController::class)->group(function () {
    Route::get('/termcondtPageMetaTagApi/index', 'index')->name('termcondtPageMetaTagApi.index');
});

Route::controller(ShipPageMetaTagApiController::class)->group(function () {
    Route::get('/shipPageMetaTagApi/index', 'index')->name('shipPageMetaTagApi.index');
});

Route::controller(SettingsApiController::class)->group(function () {
    Route::get('/sysytemSettingsApi/index', 'index')->name('sysytemSettingsApi.index');
});

Route::controller(TranslateApiController::class)->group(function () {
    Route::post('/translate', 'translate')->middleware('throttle:60,1');
});

Route::controller(SubscriptionApiController::class)->group(function () {
    Route::post('/subscribe', 'subscribe')->name('subscribe');
});

Route::controller(GoogleSnippetApiController::class)->group(function () {
    Route::get('/snippetApi', 'index')->name('snippetApi');
});

Route::controller(ShipViewApiController::class)->group(function () {
    Route::get('/shipViewApi', 'index')->name('shipViewApi');
    Route::get('/allShipDataApi', 'allShipData')->name('allShipDataApi');
});

Route::controller(ShipCabinsApiController::class)->group(function () {
    Route::get('/shipCabinApi', 'index')->name('shipCabinApi');
});

Route::controller(ShipAmenitiesApiController::class)->group(function () {
    Route::get('/shipAmenityApi', 'index')->name('shipAmenityApi');
});

Route::controller(ShipDecksApiController::class)->group(function () {
    Route::get('/shipDeckApi', 'index')->name('shipDeckApi');
});

Route::controller(CompanyInfoApiController::class)->group(function () {
    Route::get('/companyInfoApi', 'index')->name('companyInfoApi');
});
