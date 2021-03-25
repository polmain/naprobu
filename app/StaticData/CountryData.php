<?php


namespace App\StaticData;


use App\Entity\Collection\CountryCollection;

class CountryData
{
    private $countries = [
            [
                "name" => "Afghanistan",
                "code" => "AF",
                "capital" => "Kabul",
                "region" => "AS",
                "currency" => [
                "code" => "AFN",
                "name" => "Afghan afghani",
                "symbol" => "؋"
                ],
                "language" => [
                    "code" => "ps",
                    "name" => "Pashto",
                ],
                "flag" => "https://restcountries.eu/data/afg.svg",
            ],
            [
                "name" => "Åland Islands",
                "code" => "AX",
                "capital" => "Mariehamn",
                "region" => "EU",
                "currency" => [
                "code" => "EUR",
                    "name" => "Euro",
                    "symbol" => "€"
                ],
                "language" => [
                "code" => "sv",
                    "name" => "Swedish",
                ],
                "flag" => "https://restcountries.eu/data/ala.svg",
            ],
            [
                "name" => "Albania",
                "code" => "AL",
                "capital" => "Tirana",
                "region" => "EU",
                "currency" => [
                "code" => "ALL",
                    "name" => "Albanian lek",
                    "symbol" => "L"
                ],
                "language" => [
                "code" => "sq",
                    "name" => "Albanian",
                ],
                "flag" => "https://restcountries.eu/data/alb.svg",
            ],
            [
                "name" => "Algeria",
                "code" => "DZ",
                "capital" => "Algiers",
                "region" => "AF",
                "currency" => [
                "code" => "DZD",
                    "name" => "Algerian dinar",
                    "symbol" => "د.ج"
                ],
                "language" => [
                "code" => "ar",
                    "name" => "Arabic",
                ],
                "flag" => "https://restcountries.eu/data/dza.svg",
            ],
            [
                "name" => "American Samoa",
                "code" => "AS",
                "capital" => "Pago Pago",
                "region" => "OC",
                "currency" => [
                "code" => "USD",
                    "name" => "United State Dollar",
                    "symbol" => "$"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/asm.svg",
            ],
            [
                "name" => "Andorra",
                "code" => "AD",
                "capital" => "Andorra la Vella",
                "region" => "EU",
                "currency" => [
                "code" => "EUR",
                    "name" => "Euro",
                    "symbol" => "€"
                ],
                "language" => [
                "code" => "ca",
                    "name" => "Catalan",
                ],
                "flag" => "https://restcountries.eu/data/and.svg",
            ],
            [
                "name" => "Angola",
                "code" => "AO",
                "capital" => "Luanda",
                "region" => "AF",
                "currency" => [
                "code" => "AOA",
                    "name" => "Angolan kwanza",
                    "symbol" => "Kz"
                ],
                "language" => [
                "code" => "pt",
                    "name" => "Portuguese",
                ],
                "flag" => "https://restcountries.eu/data/ago.svg",
            ],
            [
                "name" => "Anguilla",
                "code" => "AI",
                "capital" => "The Valley",
                "region" => "NA",
                "currency" => [
                "code" => "XCD",
                    "name" => "East Caribbean dollar",
                    "symbol" => "$"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/aia.svg",
            ],
            [
                "name" => "Antigua and Barbuda",
                "code" => "AG",
                "capital" => "Saint John's",
                "region" => "NA",
                "currency" => [
                "code" => "XCD",
                    "name" => "East Caribbean dollar",
                    "symbol" => "$"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/atg.svg",
            ],
            [
                "name" => "Argentina",
                "code" => "AR",
                "capital" => "Buenos Aires",
                "region" => "SA",
                "currency" => [
                "code" => "ARS",
                    "name" => "Argentine peso",
                    "symbol" => "$"
                ],
                "language" => [
                "code" => "es",
                    "name" => "Spanish",
                ],
                "flag" => "https://restcountries.eu/data/arg.svg",
            ],
            [
                "name" => "Armenia",
                "code" => "AM",
                "capital" => "Yerevan",
                "region" => "AS",
                "currency" => [
                "code" => "AMD",
                    "name" => "Armenian dram",
                    "symbol" => null
                ],
                "language" => [
                "code" => "hy",
                    "name" => "Armenian",
                ],
                "flag" => "https://restcountries.eu/data/arm.svg",
            ],
            [
                "name" => "Aruba",
                "code" => "AW",
                "capital" => "Oranjestad",
                "region" => "SA",
                "currency" => [
                "code" => "AWG",
                    "name" => "Aruban florin",
                    "symbol" => "ƒ"
                ],
                "language" => [
                "code" => "nl",
                    "name" => "Dutch",
                ],
                "flag" => "https://restcountries.eu/data/abw.svg",
            ],
            [
                "name" => "Australia",
                "code" => "AU",
                "capital" => "Canberra",
                "region" => "OC",
                "currency" => [
                "code" => "AUD",
                    "name" => "Australian dollar",
                    "symbol" => "$"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/aus.svg",
            ],
            [
                "name" => "Austria",
                "code" => "AT",
                "capital" => "Vienna",
                "region" => "EU",
                "currency" => [
                "code" => "EUR",
                    "name" => "Euro",
                    "symbol" => "€"
                ],
                "language" => [
                "code" => "de",
                    "name" => "German",
                ],
                "flag" => "https://restcountries.eu/data/aut.svg",
            ],
            [
                "name" => "Azerbaijan",
                "code" => "AZ",
                "capital" => "Baku",
                "region" => "AS",
                "currency" => [
                "code" => "AZN",
                    "name" => "Azerbaijani manat",
                    "symbol" => null
                ],
                "language" => [
                "code" => "az",
                    "name" => "Azerbaijani",
                ],
                "flag" => "https://restcountries.eu/data/aze.svg",
            ],
            [
                "name" => "Bahamas",
                "code" => "BS",
                "capital" => "Nassau",
                "region" => "NA",
                "currency" => [
                "code" => "BSD",
                    "name" => "Bahamian dollar",
                    "symbol" => "$"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/bhs.svg",
            ],
            [
                "name" => "Bahrain",
                "code" => "BH",
                "capital" => "Manama",
                "region" => "AS",
                "currency" => [
                "code" => "BHD",
                    "name" => "Bahraini dinar",
                    "symbol" => ".د.ب"
                ],
                "language" => [
                "code" => "ar",
                    "name" => "Arabic",
                ],
                "flag" => "https://restcountries.eu/data/bhr.svg",
            ],
            [
                "name" => "Bangladesh",
                "code" => "BD",
                "capital" => "Dhaka",
                "region" => "AS",
                "currency" => [
                "code" => "BDT",
                    "name" => "Bangladeshi taka",
                    "symbol" => "৳"
                ],
                "language" => [
                "code" => "bn",
                    "name" => "Bengali",
                ],
                "flag" => "https://restcountries.eu/data/bgd.svg",
            ],
            [
                "name" => "Barbados",
                "code" => "BB",
                "capital" => "Bridgetown",
                "region" => "NA",
                "currency" => [
                "code" => "BBD",
                    "name" => "Barbadian dollar",
                    "symbol" => "$"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/brb.svg",
            ],
            [
                "name" => "Belarus",
                "code" => "BY",
                "capital" => "Minsk",
                "region" => "EU",
                "currency" => [
                "code" => "BYN",
                    "name" => "New Belarusian ruble",
                    "symbol" => "Br"
                ],
                "language" => [
                "code" => "be",
                    "name" => "Belarusian",
                ],
                "flag" => "https://restcountries.eu/data/blr.svg",
            ],
            [
                "name" => "Belgium",
                "code" => "BE",
                "capital" => "Brussels",
                "region" => "EU",
                "currency" => [
                "code" => "EUR",
                    "name" => "Euro",
                    "symbol" => "€"
                ],
                "language" => [
                "code" => "nl",
                    "name" => "Dutch",
                ],
                "flag" => "https://restcountries.eu/data/bel.svg",
            ],
            [
                "name" => "Belize",
                "code" => "BZ",
                "capital" => "Belmopan",
                "region" => "NA",
                "currency" => [
                "code" => "BZD",
                    "name" => "Belize dollar",
                    "symbol" => "$"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/blz.svg",
            ],
            [
                "name" => "Benin",
                "code" => "BJ",
                "capital" => "Porto-Novo",
                "region" => "AF",
                "currency" => [
                "code" => "XOF",
                    "name" => "West African CFA franc",
                    "symbol" => "Fr"
                ],
                "language" => [
                "code" => "fr",
                    "name" => "French",
                ],
                "flag" => "https://restcountries.eu/data/ben.svg",
            ],
            [
                "name" => "Bermuda",
                "code" => "BM",
                "capital" => "Hamilton",
                "region" => "NA",
                "currency" => [
                "code" => "BMD",
                    "name" => "Bermudian dollar",
                    "symbol" => "$"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/bmu.svg",
            ],
            [
                "name" => "Bhutan",
                "code" => "BT",
                "capital" => "Thimphu",
                "region" => "AS",
                "currency" => [
                "code" => "BTN",
                    "name" => "Bhutanese ngultrum",
                    "symbol" => "Nu."
                ],
                "language" => [
                "code" => "dz",
                    "name" => "Dzongkha",
                ],
                "flag" => "https://restcountries.eu/data/btn.svg",
            ],
            [
                "name" => "Bolivia (Plurinational State of)",
                "code" => "BO",
                "capital" => "Sucre",
                "region" => "SA",
                "currency" => [
                "code" => "BOB",
                    "name" => "Bolivian boliviano",
                    "symbol" => "Bs."
                ],
                "language" => [
                "code" => "es",
                    "name" => "Spanish",
                ],
                "flag" => "https://restcountries.eu/data/bol.svg",
            ],
            [
                "name" => "Bonaire, Sint Eustatius and Saba",
                "code" => "BQ",
                "capital" => "Kralendijk",
                "region" => "SA",
                "currency" => [
                "code" => "USD",
                    "name" => "United States dollar",
                    "symbol" => "$"
                ],
                "language" => [
                "code" => "nl",
                    "name" => "Dutch",
                ],
                "flag" => "https://restcountries.eu/data/bes.svg",
            ],
            [
                "name" => "Bosnia and Herzegovina",
                "code" => "BA",
                "capital" => "Sarajevo",
                "region" => "EU",
                "currency" => [
                "code" => "BAM",
                    "name" => "Bosnia and Herzegovina convertible mark",
                    "symbol" => null
                ],
                "language" => [
                "code" => "bs",
                    "name" => "Bosnian",
                ],
                "flag" => "https://restcountries.eu/data/bih.svg",
            ],
            [
                "name" => "Botswana",
                "code" => "BW",
                "capital" => "Gaborone",
                "region" => "AF",
                "currency" => [
                "code" => "BWP",
                    "name" => "Botswana pula",
                    "symbol" => "P"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/bwa.svg",
            ],
            [
                "name" => "Bouvet Island",
                "code" => "BV",
                "capital" => "",
                "region" => "AN",
                "currency" => [
                "code" => "NOK",
                    "name" => "Norwegian krone",
                    "symbol" => "kr"
                ],
                "language" => [
                "code" => "no",
                    "name" => "Norwegian",
                ],
                "flag" => "https://restcountries.eu/data/bvt.svg",
            ],
            [
                "name" => "Brazil",
                "code" => "BR",
                "capital" => "Brasília",
                "region" => "SA",
                "currency" => [
                "code" => "BRL",
                    "name" => "Brazilian real",
                    "symbol" => "R$"
                ],
                "language" => [
                "code" => "pt",
                    "name" => "Portuguese",
                ],
                "flag" => "https://restcountries.eu/data/bra.svg",
            ],
            [
                "name" => "British Indian Ocean Territory",
                "code" => "IO",
                "capital" => "Diego Garcia",
                "region" => "AF",
                "currency" => [
                "code" => "USD",
                    "name" => "United States dollar",
                    "symbol" => "$"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/iot.svg",
            ],
            [
                "name" => "United States Minor Outlying Islands",
                "code" => "UM",
                "capital" => "",
                "region" => "NA",
                "currency" => [
                "code" => "USD",
                    "name" => "United States Dollar",
                    "symbol" => "$"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/umi.svg",
            ],
            [
                "name" => "Virgin Islands (British)",
                "code" => "VG",
                "capital" => "Road Town",
                "region" => "NA",
                "currency" => [
                "code" => "USD",
                    "name" => "United States dollar",
                    "symbol" => "$"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/vgb.svg",
            ],
            [
                "name" => "Virgin Islands (U.S.)",
                "code" => "VI",
                "capital" => "Charlotte Amalie",
                "region" => "NA",
                "currency" => [
                "code" => "USD",
                    "name" => "United States dollar",
                    "symbol" => "$"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/vir.svg",
            ],
            [
                "name" => "Brunei Darussalam",
                "code" => "BN",
                "capital" => "Bandar Seri Begawan",
                "region" => "AS",
                "currency" => [
                "code" => "BND",
                    "name" => "Brunei dollar",
                    "symbol" => "$"
                ],
                "language" => [
                "code" => "ms",
                    "name" => "Malay",
                ],
                "flag" => "https://restcountries.eu/data/brn.svg",
            ],
            [
                "name" => "Bulgaria",
                "code" => "BG",
                "capital" => "Sofia",
                "region" => "EU",
                "currency" => [
                "code" => "BGN",
                    "name" => "Bulgarian lev",
                    "symbol" => "лв"
                ],
                "language" => [
                "code" => "bg",
                    "name" => "Bulgarian",
                ],
                "flag" => "https://restcountries.eu/data/bgr.svg",
            ],
            [
                "name" => "Burkina Faso",
                "code" => "BF",
                "capital" => "Ouagadougou",
                "region" => "AF",
                "currency" => [
                "code" => "XOF",
                    "name" => "West African CFA franc",
                    "symbol" => "Fr"
                ],
                "language" => [
                "code" => "fr",
                    "name" => "French",
                ],
                "flag" => "https://restcountries.eu/data/bfa.svg",
            ],
            [
                "name" => "Burundi",
                "code" => "BI",
                "capital" => "Bujumbura",
                "region" => "AF",
                "currency" => [
                "code" => "BIF",
                    "name" => "Burundian franc",
                    "symbol" => "Fr"
                ],
                "language" => [
                "code" => "fr",
                    "name" => "French",
                ],
                "flag" => "https://restcountries.eu/data/bdi.svg",
            ],
            [
                "name" => "Cambodia",
                "code" => "KH",
                "capital" => "Phnom Penh",
                "region" => "AS",
                "currency" => [
                "code" => "KHR",
                    "name" => "Cambodian riel",
                    "symbol" => "៛"
                ],
                "language" => [
                "code" => "km",
                    "name" => "Khmer",
                ],
                "flag" => "https://restcountries.eu/data/khm.svg",
            ],
            [
                "name" => "Cameroon",
                "code" => "CM",
                "capital" => "Yaoundé",
                "region" => "AF",
                "currency" => [
                "code" => "XAF",
                    "name" => "Central African CFA franc",
                    "symbol" => "Fr"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/cmr.svg",
            ],
            [
                "name" => "Canada",
                "code" => "CA",
                "capital" => "Ottawa",
                "region" => "NA",
                "currency" => [
                "code" => "CAD",
                    "name" => "Canadian dollar",
                    "symbol" => "$"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/can.svg",
            ],
            [
                "name" => "Cabo Verde",
                "code" => "CV",
                "capital" => "Praia",
                "region" => "AF",
                "currency" => [
                "code" => "CVE",
                    "name" => "Cape Verdean escudo",
                    "symbol" => "Esc"
                ],
                "language" => [
                "code" => "pt",
                    "iso639_2" => "por",
                    "name" => "Portuguese",
                    "nativeName" => "Português"
                ],
                "flag" => "https://restcountries.eu/data/cpv.svg",
            ],
            [
                "name" => "Cayman Islands",
                "code" => "KY",
                "capital" => "George Town",
                "region" => "NA",
                "demonym" => "Caymanian",
                "currency" => [
                "code" => "KYD",
                    "name" => "Cayman Islands dollar",
                    "symbol" => "$"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/cym.svg",
            ],
            [
                "name" => "Central African Republic",
                "code" => "CF",
                "capital" => "Bangui",
                "region" => "AF",
                "currency" => [
                "code" => "XAF",
                    "name" => "Central African CFA franc",
                    "symbol" => "Fr"
                ],
                "language" => [
                "code" => "fr",
                    "name" => "French",
                ],
                "flag" => "https://restcountries.eu/data/caf.svg",
            ],
            [
                "name" => "Chad",
                "code" => "TD",
                "capital" => "N'Djamena",
                "region" => "AF",
                "currency" => [
                "code" => "XAF",
                    "name" => "Central African CFA franc",
                    "symbol" => "Fr"
                ],
                "language" => [
                "code" => "fr",
                    "name" => "French",
                ],
                "flag" => "https://restcountries.eu/data/tcd.svg",
            ],
            [
                "name" => "Chile",
                "code" => "CL",
                "capital" => "Santiago",
                "region" => "SA",
                "currency" => [
                "code" => "CLP",
                    "name" => "Chilean peso",
                    "symbol" => "$"
                ],
                "language" => [
                "code" => "es",
                    "iso639_2" => "spa",
                    "name" => "Spanish",
                    "nativeName" => "Español"
                ],
                "flag" => "https://restcountries.eu/data/chl.svg",
            ],
            [
                "name" => "China",
                "code" => "CN",
                "capital" => "Beijing",
                "region" => "AS",
                "currency" => [
                "code" => "CNY",
                    "name" => "Chinese yuan",
                    "symbol" => "¥"
                ],
                "language" => [
                "code" => "zh",
                    "name" => "Chinese",
                ],
                "flag" => "https://restcountries.eu/data/chn.svg",
            ],
            [
                "name" => "Christmas Island",
                "code" => "CX",
                "capital" => "Flying Fish Cove",
                "region" => "OC",
                "currency" => [
                "code" => "AUD",
                    "name" => "Australian dollar",
                    "symbol" => "$"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/cxr.svg",
            ],
            [
                "name" => "Cocos (Keeling) Islands",
                "code" => "CC",
                "capital" => "West Island",
                "region" => "OC",
                "currency" => [
                "code" => "AUD",
                    "name" => "Australian dollar",
                    "symbol" => "$"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/cck.svg",
            ],
            [
                "name" => "Colombia",
                "code" => "CO",
                "capital" => "Bogotá",
                "region" => "SA",
                "currency" => [
                "code" => "COP",
                    "name" => "Colombian peso",
                    "symbol" => "$"
                ],
                "language" => [
                "code" => "es",
                    "name" => "Spanish",
                ],
                "flag" => "https://restcountries.eu/data/col.svg",
            ],
            [
                "name" => "Comoros",
                "code" => "KM",
                "capital" => "Moroni",
                "region" => "AF",
                "currency" => [
                "code" => "KMF",
                    "name" => "Comorian franc",
                    "symbol" => "Fr"
                ],
                "language" => [
                "code" => "fr",
                    "name" => "French",
                ],
                "flag" => "https://restcountries.eu/data/com.svg",
            ],
            [
                "name" => "Congo",
                "code" => "CG",
                "capital" => "Brazzaville",
                "region" => "AF",
                "currency" => [
                "code" => "XAF",
                    "name" => "Central African CFA franc",
                    "symbol" => "Fr"
                ],
                "language" => [
                "code" => "fr",
                    "name" => "French",
                ],
                "flag" => "https://restcountries.eu/data/cog.svg",
            ],
            [
                "name" => "Congo (Democratic Republic of the)",
                "code" => "CD",
                "capital" => "Kinshasa",
                "region" => "AF",
                "currency" => [
                "code" => "CDF",
                    "name" => "Congolese franc",
                    "symbol" => "Fr"
                ],
                "language" => [
                "code" => "fr",
                    "name" => "French",
                ],
                "flag" => "https://restcountries.eu/data/cod.svg",
            ],
            [
                "name" => "Cook Islands",
                "code" => "CK",
                "capital" => "Avarua",
                "region" => "OC",
                "currency" => [
                "code" => "NZD",
                    "name" => "New Zealand dollar",
                    "symbol" => "$"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/cok.svg",
            ],
            [
                "name" => "Costa Rica",
                "code" => "CR",
                "capital" => "San José",
                "region" => "NA",
                "currency" => [
                "code" => "CRC",
                    "name" => "Costa Rican colón",
                    "symbol" => "₡"
                ],
                "language" => [
                "code" => "es",
                    "name" => "Spanish",
                ],
                "flag" => "https://restcountries.eu/data/cri.svg",
            ],
            [
                "name" => "Croatia",
                "code" => "HR",
                "capital" => "Zagreb",
                "region" => "EU",
                "currency" => [
                "code" => "HRK",
                    "name" => "Croatian kuna",
                    "symbol" => "kn"
                ],
                "language" => [
                "code" => "hr",
                    "name" => "Croatian",
                ],
                "flag" => "https://restcountries.eu/data/hrv.svg",
            ],
            [
                "name" => "Cuba",
                "code" => "CU",
                "capital" => "Havana",
                "region" => "NA",
                "currency" => [
                "code" => "CUC",
                    "name" => "Cuban convertible peso",
                    "symbol" => "$"
                ],
                "language" => [
                "code" => "es",
                    "name" => "Spanish",
                ],
                "flag" => "https://restcountries.eu/data/cub.svg",
            ],
            [
                "name" => "Curaçao",
                "code" => "CW",
                "capital" => "Willemstad",
                "region" => "SA",
                "currency" => [
                "code" => "ANG",
                    "name" => "Netherlands Antillean guilder",
                    "symbol" => "ƒ"
                ],
                "language" => [
                "code" => "nl",
                    "name" => "Dutch",
                ],
                "flag" => "https://restcountries.eu/data/cuw.svg",
            ],
            [
                "name" => "Cyprus",
                "code" => "CY",
                "capital" => "Nicosia",
                "region" => "EU",
                "currency" => [
                "code" => "EUR",
                    "name" => "Euro",
                    "symbol" => "€"
                ],
                "language" => [
                "code" => "tr",
                    "name" => "Turkish",
                ],
                "flag" => "https://restcountries.eu/data/cyp.svg",
            ],
            [
                "name" => "Czech Republic",
                "code" => "CZ",
                "capital" => "Prague",
                "region" => "EU",
                "currency" => [
                "code" => "CZK",
                    "name" => "Czech koruna",
                    "symbol" => "Kč"
                ],
                "language" => [
                "code" => "cs",
                    "name" => "Czech",
                ],
                "flag" => "https://restcountries.eu/data/cze.svg",
            ],
            [
                "name" => "Denmark",
                "code" => "DK",
                "capital" => "Copenhagen",
                "region" => "EU",
                "currency" => [
                "code" => "DKK",
                    "name" => "Danish krone",
                    "symbol" => "kr"
                ],
                "language" => [
                "code" => "da",
                    "name" => "Danish",
                ],
                "flag" => "https://restcountries.eu/data/dnk.svg",
            ],
            [
                "name" => "Djibouti",
                "code" => "DJ",
                "capital" => "Djibouti",
                "region" => "AF",
                "currency" => [
                "code" => "DJF",
                    "name" => "Djiboutian franc",
                    "symbol" => "Fr"
                ],
                "language" => [
                "code" => "fr",
                    "name" => "French",
                ],
                "flag" => "https://restcountries.eu/data/dji.svg",
            ],
            [
                "name" => "Dominica",
                "code" => "DM",
                "capital" => "Roseau",
                "region" => "NA",
                "currency" => [
                "code" => "XCD",
                    "name" => "East Caribbean dollar",
                    "symbol" => "$"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/dma.svg",
            ],
            [
                "name" => "Dominican Republic",
                "code" => "DO",
                "capital" => "Santo Domingo",
                "region" => "NA",
                "currency" => [
                "code" => "DOP",
                    "name" => "Dominican peso",
                    "symbol" => "$"
                ],
                "language" => [
                "code" => "es",
                    "name" => "Spanish",
                ],
                "flag" => "https://restcountries.eu/data/dom.svg",
            ],
            [
                "name" => "Ecuador",
                "code" => "EC",
                "capital" => "Quito",
                "region" => "SA",
                "currency" => [
                "code" => "USD",
                    "name" => "United States dollar",
                    "symbol" => "$"
                ],
                "language" => [
                "code" => "es",
                    "name" => "Spanish",
                ],
                "flag" => "https://restcountries.eu/data/ecu.svg",
            ],
            [
                "name" => "Egypt",
                "code" => "EG",
                "capital" => "Cairo",
                "region" => "AF",
                "currency" => [
                "code" => "EGP",
                    "name" => "Egyptian pound",
                    "symbol" => "£"
                ],
                "language" => [
                "code" => "ar",
                    "name" => "Arabic",
                ],
                "flag" => "https://restcountries.eu/data/egy.svg",
            ],
            [
                "name" => "El Salvador",
                "code" => "SV",
                "capital" => "San Salvador",
                "region" => "NA",
                "currency" => [
                "code" => "USD",
                    "name" => "United States dollar",
                    "symbol" => "$"
                ],
                "language" => [
                "code" => "es",
                    "name" => "Spanish",
                ],
                "flag" => "https://restcountries.eu/data/slv.svg",
            ],
            [
                "name" => "Equatorial Guinea",
                "code" => "GQ",
                "capital" => "Malabo",
                "region" => "AF",
                "currency" => [
                "code" => "XAF",
                    "name" => "Central African CFA franc",
                    "symbol" => "Fr"
                ],
                "language" => [
                "code" => "es",
                    "iso639_2" => "spa",
                    "name" => "Spanish",
                    "nativeName" => "Español"
                ],
                "flag" => "https://restcountries.eu/data/gnq.svg",
            ],
            [
                "name" => "Eritrea",
                "code" => "ER",
                "capital" => "Asmara",
                "region" => "AF",
                "currency" => [
                "code" => "ERN",
                    "name" => "Eritrean nakfa",
                    "symbol" => "Nfk"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/eri.svg",
            ],
            [
                "name" => "Estonia",
                "code" => "EE",
                "capital" => "Tallinn",
                "region" => "EU",
                "currency" => [
                "code" => "EUR",
                    "name" => "Euro",
                    "symbol" => "€"
                ],
                "language" => [
                "code" => "et",
                    "name" => "Estonian",
                ],
                "flag" => "https://restcountries.eu/data/est.svg",
            ],
            [
                "name" => "Ethiopia",
                "code" => "ET",
                "capital" => "Addis Ababa",
                "region" => "AF",
                "currency" => [
                "code" => "ETB",
                    "name" => "Ethiopian birr",
                    "symbol" => "Br"
                ],
                "language" => [
                "code" => "am",
                    "name" => "Amharic",
                ],
                "flag" => "https://restcountries.eu/data/eth.svg",
            ],
            [
                "name" => "Falkland Islands (Malvinas)",
                "code" => "FK",
                "capital" => "Stanley",
                "region" => "SA",
                "currency" => [
                "code" => "FKP",
                    "name" => "Falkland Islands pound",
                    "symbol" => "£"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/flk.svg",
            ],
            [
                "name" => "Faroe Islands",
                "code" => "FO",
                "capital" => "Tórshavn",
                "region" => "EU",
                "currency" => [
                "code" => "DKK",
                    "name" => "Danish krone",
                    "symbol" => "kr"
                ],
                "language" => [
                "code" => "fo",
                    "name" => "Faroese",
                ],
                "flag" => "https://restcountries.eu/data/fro.svg",
            ],
            [
                "name" => "Fiji",
                "code" => "FJ",
                "capital" => "Suva",
                "region" => "OC",
                "currency" => [
                "code" => "FJD",
                    "name" => "Fijian dollar",
                    "symbol" => "$"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/fji.svg",
            ],
            [
                "name" => "Finland",
                "code" => "FI",
                "capital" => "Helsinki",
                "region" => "EU",
                "currency" => [
                "code" => "EUR",
                    "name" => "Euro",
                    "symbol" => "€"
                ],
                "language" => [
                "code" => "fi",
                    "iso639_2" => "fin",
                    "name" => "Finnish",
                    "nativeName" => "suomi"
                ],
                "flag" => "https://restcountries.eu/data/fin.svg",
            ],
            [
                "name" => "France",
                "code" => "FR",
                "capital" => "Paris",
                "region" => "EU",
                "demonym" => "French",
                "currency" => [
                "code" => "EUR",
                    "name" => "Euro",
                    "symbol" => "€"
                ],
                "language" => [
                "code" => "fr",
                    "name" => "French",
                ],
                "flag" => "https://restcountries.eu/data/fra.svg",
            ],
            [
                "name" => "French Guiana",
                "code" => "GF",
                "capital" => "Cayenne",
                "region" => "SA",
                "currency" => [
                "code" => "EUR",
                    "name" => "Euro",
                    "symbol" => "€"
                ],
                "language" => [
                "code" => "fr",
                    "name" => "French",
                ],
                "flag" => "https://restcountries.eu/data/guf.svg",
            ],
            [
                "name" => "French Polynesia",
                "code" => "PF",
                "capital" => "Papeetē",
                "region" => "OC",
                "currency" => [
                "code" => "XPF",
                    "name" => "CFP franc",
                    "symbol" => "Fr"
                ],
                "language" => [
                "code" => "fr",
                    "name" => "French",
                ],
                "flag" => "https://restcountries.eu/data/pyf.svg",
            ],
            [
                "name" => "French Southern Territories",
                "code" => "TF",
                "capital" => "Port-aux-Français",
                "region" => "AF",
                "currency" => [
                "code" => "EUR",
                    "name" => "Euro",
                    "symbol" => "€"
                ],
                "language" => [
                "code" => "fr",
                    "name" => "French",
                ],
                "flag" => "https://restcountries.eu/data/atf.svg",
            ],
            [
                "name" => "Gabon",
                "code" => "GA",
                "capital" => "Libreville",
                "region" => "AF",
                "currency" => [
                "code" => "XAF",
                    "name" => "Central African CFA franc",
                    "symbol" => "Fr"
                ],
                "language" => [
                "code" => "fr",
                    "name" => "French",
                ],
                "flag" => "https://restcountries.eu/data/gab.svg",
            ],
            [
                "name" => "Gambia",
                "code" => "GM",
                "capital" => "Banjul",
                "region" => "AF",
                "currency" => [
                "code" => "GMD",
                    "name" => "Gambian dalasi",
                    "symbol" => "D"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/gmb.svg",
            ],
            [
                "name" => "Georgia",
                "code" => "GE",
                "capital" => "Tbilisi",
                "region" => "AS",
                "currency" => [
                "code" => "GEL",
                    "name" => "Georgian Lari",
                    "symbol" => "ლ"
                ],
                "language" => [
                "code" => "ka",
                    "name" => "Georgian",
                ],
                "flag" => "https://restcountries.eu/data/geo.svg",
            ],
            [
                "name" => "Germany",
                "code" => "DE",
                "capital" => "Berlin",
                "region" => "EU",
                "currency" => [
                "code" => "EUR",
                    "name" => "Euro",
                    "symbol" => "€"
                ],
                "language" => [
                "code" => "de",
                    "name" => "German",
                ],
                "flag" => "https://restcountries.eu/data/deu.svg",
            ],
            [
                "name" => "Ghana",
                "code" => "GH",
                "capital" => "Accra",
                "region" => "AF",
                "currency" => [
                "code" => "GHS",
                    "name" => "Ghanaian cedi",
                    "symbol" => "₵"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/gha.svg",
            ],
            [
                "name" => "Gibraltar",
                "code" => "GI",
                "capital" => "Gibraltar",
                "region" => "EU",
                "currency" => [
                "code" => "GIP",
                    "name" => "Gibraltar pound",
                    "symbol" => "£"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/gib.svg",
            ],
            [
                "name" => "Greece",
                "code" => "GR",
                "capital" => "Athens",
                "region" => "EU",
                "currency" => [
                "code" => "EUR",
                    "name" => "Euro",
                    "symbol" => "€"
                ],
                "language" => [
                "code" => "el",
                    "name" => "Greek (modern)",
                ],
                "flag" => "https://restcountries.eu/data/grc.svg",
            ],
            [
                "name" => "Greenland",
                "code" => "GL",
                "capital" => "Nuuk",
                "region" => "NA",
                "currency" => [
                "code" => "DKK",
                    "name" => "Danish krone",
                    "symbol" => "kr"
                ],
                "language" => [
                "code" => "kl",
                    "name" => "Kalaallisut",
                ],
                "flag" => "https://restcountries.eu/data/grl.svg",
            ],
            [
                "name" => "Grenada",
                "code" => "GD",
                "capital" => "St. George's",
                "region" => "NA",
                "currency" => [
                "code" => "XCD",
                    "name" => "East Caribbean dollar",
                    "symbol" => "$"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/grd.svg",
            ],
            [
                "name" => "Guadeloupe",
                "code" => "GP",
                "capital" => "Basse-Terre",
                "region" => "NA",
                "currency" => [
                "code" => "EUR",
                    "name" => "Euro",
                    "symbol" => "€"
                ],
                "language" => [
                "code" => "fr",
                    "name" => "French",
                ],
                "flag" => "https://restcountries.eu/data/glp.svg",
            ],
            [
                "name" => "Guam",
                "code" => "GU",
                "capital" => "Hagåtña",
                "region" => "OC",
                "currency" => [
                "code" => "USD",
                    "name" => "United States dollar",
                    "symbol" => "$"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/gum.svg",
            ],
            [
                "name" => "Guatemala",
                "code" => "GT",
                "capital" => "Guatemala City",
                "region" => "NA",
                "currency" => [
                "code" => "GTQ",
                    "name" => "Guatemalan quetzal",
                    "symbol" => "Q"
                ],
                "language" => [
                "code" => "es",
                    "name" => "Spanish",
                ],
                "flag" => "https://restcountries.eu/data/gtm.svg",
            ],
            [
                "name" => "Guernsey",
                "code" => "GG",
                "capital" => "St. Peter Port",
                "region" => "EU",
                "currency" => [
                "code" => "GBP",
                    "name" => "British pound",
                    "symbol" => "£"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/ggy.svg",
            ],
            [
                "name" => "Guinea",
                "code" => "GN",
                "capital" => "Conakry",
                "region" => "AF",
                "currency" => [
                "code" => "GNF",
                    "name" => "Guinean franc",
                    "symbol" => "Fr"
                ],
                "language" => [
                "code" => "fr",
                    "name" => "French",
                ],
                "flag" => "https://restcountries.eu/data/gin.svg",
            ],
            [
                "name" => "Guinea-Bissau",
                "code" => "GW",
                "capital" => "Bissau",
                "region" => "AF",
                "currency" => [
                "code" => "XOF",
                    "name" => "West African CFA franc",
                    "symbol" => "Fr"
                ],
                "language" => [
                "code" => "pt",
                    "name" => "Portuguese",
                ],
                "flag" => "https://restcountries.eu/data/gnb.svg"
            ],
            [
                "name" => "Guyana",
                "code" => "GY",
                "capital" => "Georgetown",
                "region" => "SA",
                "currency" => [
                "code" => "GYD",
                    "name" => "Guyanese dollar",
                    "symbol" => "$"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/guy.svg"
            ],
            [
                "name" => "Haiti",
                "code" => "HT",
                "capital" => "Port-au-Prince",
                "region" => "Americas",
                "currency" => [
                "code" => "HTG",
                    "name" => "Haitian gourde",
                    "symbol" => "G"
                ],
                "language" => [
                "code" => "fr",
                    "name" => "French",
                ],
                "flag" => "https://restcountries.eu/data/hti.svg"
            ],
            [
                "name" => "Heard Island and McDonald Islands",
                "code" => "HM",
                "capital" => "",
                "region" => "",
                "currency" => [
                "code" => "AUD",
                    "name" => "Australian dollar",
                    "symbol" => "$"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/hmd.svg"
            ],
            [
                "name" => "Holy See",
                "code" => "VA",
                "capital" => "Rome",
                "region" => "EU",
                "currency" => [
                "code" => "EUR",
                    "name" => "Euro",
                    "symbol" => "€"
                ],
                "language" => [
                "code" => "fr",
                    "name" => "French",
                ],
                "flag" => "https://restcountries.eu/data/vat.svg"
            ],
            [
                "name" => "Honduras",
                "code" => "HN",
                "capital" => "Tegucigalpa",
                "region" => "NA",
                "currency" => [
                "code" => "HNL",
                    "name" => "Honduran lempira",
                    "symbol" => "L"
                ],
                "language" => [
                "code" => "es",
                    "name" => "Spanish",
                ],
                "flag" => "https://restcountries.eu/data/hnd.svg"
            ],
            [
                "name" => "Hong Kong",
                "code" => "HK",
                "capital" => "City of Victoria",
                "region" => "AS",
                "currency" => [
                "code" => "HKD",
                    "name" => "Hong Kong dollar",
                    "symbol" => "$"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/hkg.svg"
            ],
            [
                "name" => "Hungary",
                "code" => "HU",
                "capital" => "Budapest",
                "region" => "EU",
                "currency" => [
                "code" => "HUF",
                    "name" => "Hungarian forint",
                    "symbol" => "Ft"
                ],
                "language" => [
                "code" => "hu",
                    "name" => "Hungarian",
                ],
                "flag" => "https://restcountries.eu/data/hun.svg"
            ],
            [
                "name" => "Iceland",
                "code" => "IS",
                "capital" => "Reykjavík",
                "region" => "EU",
                "currency" => [
                "code" => "ISK",
                    "name" => "Icelandic króna",
                    "symbol" => "kr"
                ],
                "language" => [
                "code" => "is",
                    "name" => "Icelandic",
                ],
                "flag" => "https://restcountries.eu/data/isl.svg"
            ],
            [
                "name" => "India",
                "code" => "IN",
                "capital" => "New Delhi",
                "region" => "AS",
                "currency" => [
                "code" => "INR",
                    "name" => "Indian rupee",
                    "symbol" => "₹"
                ],
                "language" => [
                "code" => "hi",
                    "name" => "Hindi",
                ],
                "flag" => "https://restcountries.eu/data/ind.svg"
            ],
            [
                "name" => "Indonesia",
                "code" => "ID",
                "capital" => "Jakarta",
                "region" => "AS",
                "currency" => [
                "code" => "IDR",
                    "name" => "Indonesian rupiah",
                    "symbol" => "Rp"
                ],
                "language" => [
                "code" => "id",
                    "name" => "Indonesian",
                ],
                "flag" => "https://restcountries.eu/data/idn.svg"
            ],
            [
                "name" => "Côte d'Ivoire",
                "code" => "CI",
                "capital" => "Yamoussoukro",
                "region" => "AF",
                "currency" => [
                "code" => "XOF",
                    "name" => "West African CFA franc",
                    "symbol" => "Fr"
                ],
                "language" => [
                "code" => "fr",
                    "name" => "French",
                ],
                "flag" => "https://restcountries.eu/data/civ.svg"
            ],
            [
                "name" => "Iran (Islamic Republic of)",
                "code" => "IR",
                "capital" => "Tehran",
                "region" => "AS",
                "currency" => [
                "code" => "IRR",
                    "name" => "Iranian rial",
                    "symbol" => "﷼"
                ],
                "language" => [
                "code" => "fa",
                    "name" => "Persian (Farsi)",
                ],
                "flag" => "https://restcountries.eu/data/irn.svg"
            ],
            [
                "name" => "Iraq",
                "code" => "IQ",
                "capital" => "Baghdad",
                "region" => "AS",
                "currency" => [
                "code" => "IQD",
                    "name" => "Iraqi dinar",
                    "symbol" => "ع.د"
                ],
                "language" => [
                "code" => "ar",
                    "name" => "Arabic",
                 ],
                "flag" => "https://restcountries.eu/data/irq.svg"
            ],
            [
                "name" => "Ireland",
                "code" => "IE",
                "capital" => "Dublin",
                "region" => "EU",
                "currency" => [
                "code" => "EUR",
                    "name" => "Euro",
                    "symbol" => "€"
                ],
                "language" => [
                "code" => "ga",
                    "name" => "Irish",
                 ],
                "flag" => "https://restcountries.eu/data/irl.svg"
            ],
            [
                "name" => "Isle of Man",
                "code" => "IM",
                "capital" => "Douglas",
                "region" => "EU",
                "currency" => [
                "code" => "GBP",
                    "name" => "British pound",
                    "symbol" => "£"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/imn.svg"
            ],
            [
                "name" => "Israel",
                "code" => "IL",
                "capital" => "Jerusalem",
                "region" => "AS",
                "currency" => [
                "code" => "ILS",
                    "name" => "Israeli new shekel",
                    "symbol" => "₪"
                ],
                "language" => [
                "code" => "he",
                    "name" => "Hebrew (modern)",
                 ],
                "flag" => "https://restcountries.eu/data/isr.svg"
            ],
            [
                "name" => "Italy",
                "code" => "IT",
                "capital" => "Rome",
                "region" => "EU",
                "currency" => [
                "code" => "EUR",
                    "name" => "Euro",
                    "symbol" => "€"
                ],
                "language" => [
                "code" => "it",
                    "name" => "Italian",
                ],
                "flag" => "https://restcountries.eu/data/ita.svg"
           ],
           [
               "name" => "Jamaica",
                "code" => "JM",
                "capital" => "Kingston",
                "region" => "NA",
                "currency" => [
               "code" => "JMD",
                    "name" => "Jamaican dollar",
                    "symbol" => "$"
                ],
                "language" => [
               "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/jam.svg"
            ],
            [
                "name" => "Japan",
                "code" => "JP",
                "capital" => "Tokyo",
                "region" => "AS",
                "currency" => [
                "code" => "JPY",
                    "name" => "Japanese yen",
                    "symbol" => "¥"
                ],
                "language" => [
                "code" => "ja",
                    "name" => "Japanese",
                ],
                "flag" => "https://restcountries.eu/data/jpn.svg"
            ],
            [
                "name" => "Jersey",
                "code" => "JE",
                "capital" => "Saint Helier",
                "region" => "EU",
                "currency" => [
                "code" => "GBP",
                    "name" => "British pound",
                    "symbol" => "£"
                 ],
                "language" => [
                "code" => "en",
                    "iso639_2" => "eng",
                    "name" => "English",
                    "nativeName" => "English"
                 ],
                "flag" => "https://restcountries.eu/data/jey.svg"
            ],
            [
                "name" => "Jordan",
                "code" => "JO",
                "capital" => "Amman",
                "region" => "AS",
                "currency" => [
                "code" => "JOD",
                    "name" => "Jordanian dinar",
                    "symbol" => "د.ا"
                ],
                "language" => [
                "code" => "ar",
                    "name" => "Arabic",
                ],
                "flag" => "https://restcountries.eu/data/jor.svg"
            ],
            [
                "name" => "Kazakhstan",
                "code" => "KZ",
                "capital" => "Astana",
                "region" => "AS",
                "currency" => [
                "code" => "KZT",
                    "name" => "Kazakhstani tenge",
                    "symbol" => null
                ],
                "language" => [
                "code" => "kk",
                    "name" => "Kazakh",
                ],
                "flag" => "https://restcountries.eu/data/kaz.svg"
            ],
            [
                "name" => "Kenya",
                "code" => "KE",
                "capital" => "Nairobi",
                "region" => "AF",
                "currency" => [
                "code" => "KES",
                    "name" => "Kenyan shilling",
                    "symbol" => "Sh"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/ken.svg"
            ],
            [
                "name" => "Kiribati",
                "code" => "KI",
                "capital" => "South Tarawa",
                "region" => "OC",
                "currency" => [
                "code" => "AUD",
                    "name" => "Australian dollar",
                    "symbol" => "$"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/kir.svg"
            ],
            [
                "name" => "Kuwait",
                "code" => "KW",
                "capital" => "Kuwait City",
                "region" => "AS",
                "currency" => [
                "code" => "KWD",
                    "name" => "Kuwaiti dinar",
                    "symbol" => "د.ك"
                ],
                "language" => [
                "code" => "ar",
                    "name" => "Arabic",
                ],
                "flag" => "https://restcountries.eu/data/kwt.svg"
            ],
            [
                "name" => "Kyrgyzstan",
                "code" => "KG",
                "capital" => "Bishkek",
                "region" => "AS",
                "currency" => [
                "code" => "KGS",
                    "name" => "Kyrgyzstani som",
                    "symbol" => "с"
                ],
                "language" => [
                "code" => "ky",
                    "name" => "Kyrgyz",
                ],
                "flag" => "https://restcountries.eu/data/kgz.svg"
            ],
            [
                "name" => "Lao People's Democratic Republic",
                "code" => "LA",
                "capital" => "Vientiane",
                "region" => "AS",
                "currency" => [
                "code" => "LAK",
                    "name" => "Lao kip",
                    "symbol" => "₭"
                ],
                "language" => [
                "code" => "lo",
                    "name" => "Lao",
                ],
                "flag" => "https://restcountries.eu/data/lao.svg"
            ],
            [
                "name" => "Latvia",
                "code" => "LV",
                "capital" => "Riga",
                "region" => "EU",
                "currency" => [
                "code" => "EUR",
                    "name" => "Euro",
                    "symbol" => "€"
                ],
                "language" => [
                "code" => "lv",
                    "name" => "Latvian",
                ],
                "flag" => "https://restcountries.eu/data/lva.svg"
            ],
            [
                "name" => "Lebanon",
                "code" => "LB",
                "capital" => "Beirut",
                "region" => "AS",
                "currency" => [
                "code" => "LBP",
                    "name" => "Lebanese pound",
                    "symbol" => "ل.ل"
                ],
                "language" => [
                "code" => "ar",
                    "name" => "Arabic",
                 ],
                "flag" => "https://restcountries.eu/data/lbn.svg"
            ],
            [
                "name" => "Lesotho",
                "code" => "LS",
                "capital" => "Maseru",
                "region" => "AF",
                "currency" => [
                "code" => "LSL",
                    "name" => "Lesotho loti",
                    "symbol" => "L"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/lso.svg"
            ],
            [
                "name" => "Liberia",
                "code" => "LR",
                "capital" => "Monrovia",
                "region" => "AF",
                "currency" => [
                "code" => "LRD",
                    "name" => "Liberian dollar",
                    "symbol" => "$"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/lbr.svg"
            ],
            [
                "name" => "Libya",
                "code" => "LY",
                "capital" => "Tripoli",
                "region" => "AF",
                "currency" => [
                "code" => "LYD",
                    "name" => "Libyan dinar",
                    "symbol" => "ل.د"
                ],
                "language" => [
                "code" => "ar",
                    "name" => "Arabic",
                ],
                "flag" => "https://restcountries.eu/data/lby.svg"
            ],
            [
                "name" => "Liechtenstein",
                "code" => "LI",
                "capital" => "Vaduz",
                "region" => "EU",
                "currency" => [
                "code" => "CHF",
                    "name" => "Swiss franc",
                    "symbol" => "Fr"
                ],
                "language" => [
                "code" => "de",
                    "name" => "German",
                ],
                "flag" => "https://restcountries.eu/data/lie.svg"
            ],
            [
                "name" => "Lithuania",
                "code" => "LT",
                "capital" => "Vilnius",
                "region" => "EU",
                "currency" => [
                "code" => "EUR",
                    "name" => "Euro",
                    "symbol" => "€"
                ],
                "language" => [
                "code" => "lt",
                    "name" => "Lithuanian",
                ],
                "flag" => "https://restcountries.eu/data/ltu.svg"
            ],
            [
                "name" => "Luxembourg",
                "code" => "LU",
                "capital" => "Luxembourg",
                "region" => "EU",
                "currency" => [
                "code" => "EUR",
                    "name" => "Euro",
                    "symbol" => "€"
                ],
                "language" => [
                "code" => "fr",
                    "name" => "French",
                ],
                "flag" => "https://restcountries.eu/data/lux.svg"
            ],
            [
                "name" => "Macao",
                "code" => "MO",
                "capital" => "",
                "region" => "AS",
                "currency" => [
                "code" => "MOP",
                    "name" => "Macanese pataca",
                    "symbol" => "P"
                ],
                "language" => [
                "code" => "zh",
                    "name" => "Chinese",
                ],
                "flag" => "https://restcountries.eu/data/mac.svg"
            ],
            [
                "name" => "Macedonia (the former Yugoslav Republic of)",
                "code" => "MK",
                "capital" => "Skopje",
                "region" => "EU",
                "currency" => [
                "code" => "MKD",
                    "name" => "Macedonian denar",
                    "symbol" => "ден"
                ],
                "language" => [
                "code" => "mk",
                    "name" => "Macedonian",
                ],
                "flag" => "https://restcountries.eu/data/mkd.svg"
            ],
            [
                "name" => "Madagascar",
                "code" => "MG",
                "capital" => "Antananarivo",
                "region" => "AF",
                "currency" => [
                "code" => "MGA",
                    "name" => "Malagasy ariary",
                    "symbol" => "Ar"
                ],
                "language" => [
                "code" => "fr",
                    "name" => "French",
                ],
                "flag" => "https://restcountries.eu/data/mdg.svg"
            ],
            [
                "name" => "Malawi",
                "code" => "MW",
                "capital" => "Lilongwe",
                "region" => "AF",
                "currency" => [
                "code" => "MWK",
                    "name" => "Malawian kwacha",
                    "symbol" => "MK"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/mwi.svg"
            ],
            [
                "name" => "Malaysia",
                "code" => "MY",
                "capital" => "Kuala Lumpur",
                "region" => "AS",
                "currency" => [
                "code" => "MYR",
                    "name" => "Malaysian ringgit",
                    "symbol" => "RM"
                ],
                "language" => [
                "code" => null,
                    "name" => "Malaysian",
                ],
            "flag" => "https://restcountries.eu/data/mys.svg"
            ],
            [
                "name" => "Maldives",
                "code" => "MV",
                "capital" => "Malé",
                "region" => "AS",
                "currency" => [
                "code" => "MVR",
                    "name" => "Maldivian rufiyaa",
                    "symbol" => ".ރ"
                ],
                "language" => [
                "code" => "dv",
                    "name" => "Divehi",
                ],
                "flag" => "https://restcountries.eu/data/mdv.svg"
            ],
            [
                "name" => "Mali",
                "code" => "ML",
                "capital" => "Bamako",
                "region" => "AF",
                "currency" => [
                "code" => "XOF",
                    "name" => "West African CFA franc",
                    "symbol" => "Fr"
                ],
                "language" => [
                "code" => "fr",
                    "name" => "French",
                ],
                "flag" => "https://restcountries.eu/data/mli.svg"
            ],
            [
                "name" => "Malta",
                "code" => "MT",
                "capital" => "Valletta",
                "region" => "EU",
                "currency" => [
                "code" => "EUR",
                    "name" => "Euro",
                    "symbol" => "€"
                ],
                "language" => [
                "code" => "mt",
                    "name" => "Maltese",
                ],
                "flag" => "https://restcountries.eu/data/mlt.svg"
            ],
            [
                "name" => "Marshall Islands",
                "code" => "MH",
                "capital" => "Majuro",
                "region" => "OC",
                "currency" => [
                "code" => "USD",
                    "name" => "United States dollar",
                    "symbol" => "$"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/mhl.svg"
            ],
            [
                "name" => "Martinique",
                "code" => "MQ",
                "capital" => "Fort-de-France",
                "region" => "Americas",
                "currency" => [
                "code" => "EUR",
                    "name" => "Euro",
                    "symbol" => "€"
                ],
                "language" => [
                "code" => "fr",
                    "name" => "French",
                ],
                "flag" => "https://restcountries.eu/data/mtq.svg"
            ],
            [
                "name" => "Mauritania",
                "code" => "MR",
                "capital" => "Nouakchott",
                "region" => "AF",
                "currency" => [
                "code" => "MRO",
                    "name" => "Mauritanian ouguiya",
                    "symbol" => "UM"
                ],
                "language" => [
                "code" => "ar",
                    "name" => "Arabic",
                ],
                "flag" => "https://restcountries.eu/data/mrt.svg"
            ],
            [
                "name" => "Mauritius",
                "code" => "MU",
                "capital" => "Port Louis",
                "region" => "AF",
                "currency" => [
                "code" => "MUR",
                    "name" => "Mauritian rupee",
                    "symbol" => "₨"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/mus.svg"
            ],
            [
                "name" => "Mayotte",
                "code" => "YT",
                "capital" => "Mamoudzou",
                "region" => "AF",
                "currency" => [
                "code" => "EUR",
                    "name" => "Euro",
                    "symbol" => "€"
                ],
                "language" => [
                "code" => "fr",
                    "name" => "French",
                ],
                "flag" => "https://restcountries.eu/data/myt.svg"
            ],
            [
                "name" => "Mexico",
                "code" => "MX",
                "capital" => "Mexico City",
                "region" => "NA",
                "currency" => [
                "code" => "MXN",
                    "name" => "Mexican peso",
                    "symbol" => "$"
                ],
                "language" => [
                "code" => "es",
                    "name" => "Spanish",
                ],
                "flag" => "https://restcountries.eu/data/mex.svg"
            ],
            [
                "name" => "Micronesia (Federated States of)",
                "code" => "FM",
                "capital" => "Palikir",
                "region" => "OC",
                "currency" => [
                "code" => "USD",
                    "name" => "United States dollar",
                    "symbol" => "$"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/fsm.svg"
            ],
            [
                "name" => "Moldova (Republic of)",
                "code" => "MD",
                "capital" => "Chișinău",
                "region" => "EU",
                "currency" => [
                "code" => "MDL",
                    "name" => "Moldovan leu",
                    "symbol" => "L"
                ],
                "language" => [
                "code" => "ro",
                    "name" => "Romanian",
                ],
                "flag" => "https://restcountries.eu/data/mda.svg"
            ],
            [
                "name" => "Monaco",
                "code" => "MC",
                "capital" => "Monaco",
                "region" => "EU",
                "currency" => [
                "code" => "EUR",
                    "name" => "Euro",
                    "symbol" => "€"
                ],
                "language" => [
                "code" => "fr",
                    "name" => "French",
                ],
                "flag" => "https://restcountries.eu/data/mco.svg"
            ],
            [
                "name" => "Mongolia",
                "code" => "MN",
                "capital" => "Ulan Bator",
                "region" => "AS",
                "currency" => [
                "code" => "MNT",
                    "name" => "Mongolian tögrög",
                    "symbol" => "₮"
                ],
                "language" => [
                "code" => "mn",
                    "name" => "Mongolian",
                ],
                "flag" => "https://restcountries.eu/data/mng.svg"
            ],
            [
                "name" => "Montenegro",
                "code" => "ME",
                "capital" => "Podgorica",
                "region" => "EU",
                "currency" => [
                "code" => "EUR",
                    "name" => "Euro",
                    "symbol" => "€"
                ],
                "language" => [
                "code" => "sr",
                    "name" => "Serbian",
                ],
                "flag" => "https://restcountries.eu/data/mne.svg"
            ],
            [
                "name" => "Montserrat",
                "code" => "MS",
                "capital" => "Plymouth",
                "region" => "NA",
                "currency" => [
                "code" => "XCD",
                    "name" => "East Caribbean dollar",
                    "symbol" => "$"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/msr.svg"
            ],
            [
                "name" => "Morocco",
                "code" => "MA",
                "capital" => "Rabat",
                "region" => "AF",
                "currency" => [
                "code" => "MAD",
                    "name" => "Moroccan dirham",
                    "symbol" => "د.م."
                ],
                "language" => [
                "code" => "ar",
                    "name" => "Arabic",
                ],
                "flag" => "https://restcountries.eu/data/mar.svg"
            ],
            [
                "name" => "Mozambique",
                "code" => "MZ",
                "capital" => "Maputo",
                "region" => "AF",
                "currency" => [
                "code" => "MZN",
                    "name" => "Mozambican metical",
                    "symbol" => "MT"
                ],
                "language" => [
                "code" => "pt",
                    "name" => "Portuguese",
                ],
                "flag" => "https://restcountries.eu/data/moz.svg"
            ],
            [
                "name" => "Myanmar",
                "code" => "MM",
                "capital" => "Naypyidaw",
                "region" => "AS",
                "currency" => [
                "code" => "MMK",
                    "name" => "Burmese kyat",
                    "symbol" => "Ks"
                ],
                "language" => [
                "code" => "my",
                    "name" => "Burmese",
                ],
                "flag" => "https://restcountries.eu/data/mmr.svg"
            ],
            [
                "name" => "Namibia",
                "code" => "NA",
                "capital" => "Windhoek",
                "region" => "AF",
                "currency" => [
                "code" => "NAD",
                    "name" => "Namibian dollar",
                    "symbol" => "$"
                 ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/nam.svg"
            ],
            [
                "name" => "Nauru",
                "code" => "NR",
                "capital" => "Yaren",
                "region" => "OC",
                "currency" => [
                "code" => "AUD",
                    "name" => "Australian dollar",
                    "symbol" => "$"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                 ],
                "flag" => "https://restcountries.eu/data/nru.svg"
            ],
            [
                "name" => "Nepal",
                "code" => "NP",
                "capital" => "Kathmandu",
                "region" => "AS",
                "currency" => [
                "code" => "NPR",
                    "name" => "Nepalese rupee",
                    "symbol" => "₨"
                ],
                "language" => [
                "code" => "ne",
                    "name" => "Nepali",
                ],
                "flag" => "https://restcountries.eu/data/npl.svg"
            ],
            [
                "name" => "Netherlands",
                "code" => "NL",
                "capital" => "Amsterdam",
                "region" => "EU",
                "currency" => [
                "code" => "EUR",
                    "name" => "Euro",
                    "symbol" => "€"
                ],
                "language" => [
                "code" => "nl",
                    "name" => "Dutch",
                ],
                "flag" => "https://restcountries.eu/data/nld.svg"
            ],
            [
                "name" => "New Caledonia",
                "code" => "NC",
                "capital" => "Nouméa",
                "region" => "OC",
                "currency" => [
                "code" => "XPF",
                    "name" => "CFP franc",
                    "symbol" => "Fr"
                ],
                "language" => [
                "code" => "fr",
                    "name" => "French",
                ],
                "flag" => "https://restcountries.eu/data/ncl.svg"
            ],
            [
                "name" => "New Zealand",
                "code" => "NZ",
                "capital" => "Wellington",
                "region" => "OC",
                "currency" => [
                "code" => "NZD",
                    "name" => "New Zealand dollar",
                    "symbol" => "$"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/nzl.svg"
           ],
           [
               "name" => "Nicaragua",
                "code" => "NI",
                "capital" => "Managua",
                "region" => "NA",
                "currency" => [
               "code" => "NIO",
                    "name" => "Nicaraguan córdoba",
                    "symbol" => "C$"
                ],
                "language" => [
               "code" => "es",
                    "name" => "Spanish",
                ],
                "flag" => "https://restcountries.eu/data/nic.svg"
            ],
            [
                "name" => "Niger",
                "code" => "NE",
                "capital" => "Niamey",
                "region" => "AF",
                "currency" => [
                "code" => "XOF",
                    "name" => "West African CFA franc",
                    "symbol" => "Fr"
                ],
                "language" => [
                "code" => "fr",
                    "name" => "French",
                ],
                "flag" => "https://restcountries.eu/data/ner.svg"
            ],
            [
                "name" => "Nigeria",
                "code" => "NG",
                "capital" => "Abuja",
                "region" => "AF",
                "currency" => [
                "code" => "NGN",
                    "name" => "Nigerian naira",
                    "symbol" => "₦"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/nga.svg"
            ],
            [
                "name" => "Niue",
                "code" => "NU",
                "capital" => "Alofi",
                "region" => "OC",
                "currency" => [
                "code" => "NZD",
                    "name" => "New Zealand dollar",
                    "symbol" => "$"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/niu.svg"
            ],
            [
                "name" => "Norfolk Island",
                "code" => "NF",
                "capital" => "Kingston",
                "region" => "OC",
                "currency" => [
                "code" => "AUD",
                    "name" => "Australian dollar",
                    "symbol" => "$"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/nfk.svg"
            ],
            [
                "name" => "Korea (Democratic People's Republic of)",
                "code" => "KP",
                "capital" => "Pyongyang",
                "region" => "AS",
                "currency" => [
                "code" => "KPW",
                    "name" => "North Korean won",
                    "symbol" => "₩"
                ],
                "language" => [
                "code" => "ko",
                    "name" => "Korean",
                ],
                "flag" => "https://restcountries.eu/data/prk.svg"
            ],
            [
                "name" => "Northern Mariana Islands",
                "code" => "MP",
                "capital" => "Saipan",
                "region" => "OC",
                "currency" => [
                "code" => "USD",
                    "name" => "United States dollar",
                    "symbol" => "$"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/mnp.svg"
            ],
            [
                "name" => "Norway",
                "code" => "NO",
                "capital" => "Oslo",
                "region" => "EU",
                "currency" => [
                "code" => "NOK",
                    "name" => "Norwegian krone",
                    "symbol" => "kr"
                ],
                "language" => [
                "code" => "no",
                    "name" => "Norwegian",
                ],
                "flag" => "https://restcountries.eu/data/nor.svg"
            ],
            [
                "name" => "Oman",
                "code" => "OM",
                "capital" => "Muscat",
                "region" => "AS",
                "currency" => [
                "code" => "OMR",
                    "name" => "Omani rial",
                    "symbol" => "ر.ع."
                ],
                "language" => [
                "code" => "ar",
                    "name" => "Arabic",
                ],
                "flag" => "https://restcountries.eu/data/omn.svg"
            ],
            [
                "name" => "Pakistan",
                "code" => "PK",
                "capital" => "Islamabad",
                "region" => "AS",
                "currency" => [
                "code" => "PKR",
                    "name" => "Pakistani rupee",
                    "symbol" => "₨"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/pak.svg"
            ],
            [
                "name" => "Palau",
              "code" => "PW",
              "capital" => "Ngerulmud",
              "region" => "OC",
              "currency" => [
                "code" => "USD",
                    "name" => "United States dollar",
                    "symbol" => "$"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/plw.svg"
            ],
            [
                "name" => "Palestine, State of",
                "code" => "PS",
                "capital" => "Ramallah",
                "region" => "AS",
                "currency" => [
                "code" => "ILS",
                    "name" => "Israeli new sheqel",
                    "symbol" => "₪"
                ],
                "language" => [
                "code" => "ar",
                    "name" => "Arabic",
                ],
                "flag" => "https://restcountries.eu/data/pse.svg"
            ],
            [
                "name" => "Panama",
                "code" => "PA",
                "capital" => "Panama City",
                "region" => "NA",
                "currency" => [
                "code" => "USD",
                    "name" => "United States dollar",
                    "symbol" => "$"
                ],
                "language" => [
                "code" => "es",
                    "name" => "Spanish",
                ],
                "flag" => "https://restcountries.eu/data/pan.svg"
            ],
            [
                "name" => "Papua New Guinea",
                "code" => "PG",
                "capital" => "Port Moresby",
                "region" => "OC",
                "currency" => [
                "code" => "PGK",
                    "name" => "Papua New Guinean kina",
                    "symbol" => "K"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/png.svg"
            ],
            [
                "name" => "Paraguay",
                "code" => "PY",
                "capital" => "Asunción",
                "region" => "SA",
                "currency" => [
                "code" => "PYG",
                    "name" => "Paraguayan guaraní",
                    "symbol" => "₲"
                ],
                "language" => [
                "code" => "es",
                    "name" => "Spanish",
                ],
                "flag" => "https://restcountries.eu/data/pry.svg"
            ],
            [
                "name" => "Peru",
                "code" => "PE",
                "capital" => "Lima",
                "region" => "SA",
                "currency" => [
                "code" => "PEN",
                    "name" => "Peruvian sol",
                    "symbol" => "S/."
                ],
                "language" => [
                "code" => "es",
                    "name" => "Spanish",
                ],
                "flag" => "https://restcountries.eu/data/per.svg"
            ],
            [
                "name" => "Philippines",
                "code" => "PH",
                "capital" => "Manila",
                "region" => "AS",
                "currency" => [
                "code" => "PHP",
                    "name" => "Philippine peso",
                    "symbol" => "₱"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/phl.svg"
            ],
            [
                "name" => "Pitcairn",
                "code" => "PN",
                "capital" => "Adamstown",
                "region" => "OC",
                "currency" => [
                "code" => "NZD",
                    "name" => "New Zealand dollar",
                    "symbol" => "$"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/pcn.svg"
            ],
            [
                "name" => "Poland",
                "code" => "PL",
                "capital" => "Warsaw",
                "region" => "EU",
                "currency" => [
                "code" => "PLN",
                    "name" => "Polish złoty",
                    "symbol" => "zł"
                ],
                "language" => [
                "code" => "pl",
                    "name" => "Polish",
                ],
                "flag" => "https://restcountries.eu/data/pol.svg"
            ],
            [
                "name" => "Portugal",
                "code" => "PT",
                "capital" => "Lisbon",
                "region" => "EU",
                "currency" => [
                "code" => "EUR",
                    "name" => "Euro",
                    "symbol" => "€"
                ],
                "language" => [
                "code" => "pt",
                    "name" => "Portuguese",
                ],
                "flag" => "https://restcountries.eu/data/prt.svg"
            ],
            [
                "name" => "Puerto Rico",
                "code" => "PR",
                "capital" => "San Juan",
                "region" => "NA",
                "currency" => [
                "code" => "USD",
                    "name" => "United States dollar",
                    "symbol" => "$"
                ],
                "language" => [
                "code" => "es",
                    "name" => "Spanish",
                ],
                "flag" => "https://restcountries.eu/data/pri.svg"
            ],
            [
                "name" => "Qatar",
                "code" => "QA",
                "capital" => "Doha",
                "region" => "AS",
                "currency" => [
                "code" => "QAR",
                    "name" => "Qatari riyal",
                    "symbol" => "ر.ق"
                ],
                "language" => [
                "code" => "ar",
                    "name" => "Arabic",
                ],
                "flag" => "https://restcountries.eu/data/qat.svg"
            ],
            [
                "name" => "Republic of Kosovo",
                "code" => "XK",
                "capital" => "Pristina",
                "region" => "EU",
                "currency" => [
                "code" => "EUR",
                    "name" => "Euro",
                    "symbol" => "€"
                ],
                "language" => [
                "code" => "sq",
                    "name" => "Albanian",
                 ],
                "flag" => "https://restcountries.eu/data/kos.svg"
            ],
            [
                "name" => "Réunion",
                "code" => "RE",
                "capital" => "Saint-Denis",
                "region" => "AF",
                "currency" => [
                "code" => "EUR",
                    "name" => "Euro",
                    "symbol" => "€"
                ],
                "language" => [
                "code" => "fr",
                    "name" => "French",
                 ],
                "flag" => "https://restcountries.eu/data/reu.svg"
            ],
            [
                "name" => "Romania",
                "code" => "RO",
                "capital" => "Bucharest",
                "region" => "EU",
                "currency" => [
                "code" => "RON",
                    "name" => "Romanian leu",
                    "symbol" => "lei"
                ],
                "language" => [
                "code" => "ro",
                    "name" => "Romanian",
                ],
                "flag" => "https://restcountries.eu/data/rou.svg"
            ],
            [
                "name" => "Russian Federation",
                "code" => "RU",
                "capital" => "Moscow",
                "region" => "EU",
                "currency" => [
                "code" => "RUB",
                    "name" => "Russian ruble",
                    "symbol" => "₽"
                ],
                "language" => [
                "code" => "ru",
                    "name" => "Russian",
                ],
                "flag" => "https://restcountries.eu/data/rus.svg"
            ],
            [
                "name" => "Rwanda",
                "code" => "RW",
                "capital" => "Kigali",
                "region" => "AF",
                "currency" => [
                "code" => "RWF",
                    "name" => "Rwandan franc",
                    "symbol" => "Fr"
                ],
                "language" => [
                "code" => "rw",
                    "name" => "Kinyarwanda",
                 ],
                "flag" => "https://restcountries.eu/data/rwa.svg"
            ],
            [
                "name" => "Saint Barthélemy",
                "code" => "BL",
                "capital" => "Gustavia",
                "region" => "NA",
                "currency" => [
                "code" => "EUR",
                    "name" => "Euro",
                    "symbol" => "€"
                ],
                "language" => [
                "code" => "fr",
                    "name" => "French",
                ],
                "flag" => "https://restcountries.eu/data/blm.svg"
            ],
            [
                "name" => "Saint Helena, Ascension and Tristan da Cunha",
                "code" => "SH",
                "capital" => "Jamestown",
                "region" => "AF",
                "currency" => [
                "code" => "SHP",
                    "name" => "Saint Helena pound",
                    "symbol" => "£"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/shn.svg"
            ],
            [
                "name" => "Saint Kitts and Nevis",
                "code" => "KN",
                "capital" => "Basseterre",
                "region" => "NA",
                "currency" => [
                "code" => "XCD",
                    "name" => "East Caribbean dollar",
                    "symbol" => "$"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/kna.svg"
            ],
            [
                "name" => "Saint Lucia",
                "code" => "LC",
                "capital" => "Castries",
                "region" => "NA",
                "currency" => [
                "code" => "XCD",
                    "name" => "East Caribbean dollar",
                    "symbol" => "$"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/lca.svg"
            ],
            [
                "name" => "Saint Martin (French part)",
                "code" => "MF",
                "capital" => "Marigot",
                "region" => "NA",
                "currency" => [
                "code" => "EUR",
                    "name" => "Euro",
                    "symbol" => "€"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/maf.svg"
            ],
            [
                "name" => "Saint Pierre and Miquelon",
                "code" => "PM",
                "capital" => "Saint-Pierre",
                "region" => "NA",
                "currency" => [
                "code" => "EUR",
                    "name" => "Euro",
                    "symbol" => "€"
                ],
                "language" => [
                "code" => "fr",
                    "name" => "French",
                ],
                "flag" => "https://restcountries.eu/data/spm.svg"
            ],
            [
                "name" => "Saint Vincent and the Grenadines",
                "code" => "VC",
                "capital" => "Kingstown",
                "region" => "NA",
                "currency" => [
                "code" => "XCD",
                    "name" => "East Caribbean dollar",
                    "symbol" => "$"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/vct.svg"
            ],
            [
                "name" => "Samoa",
                "code" => "WS",
                "capital" => "Apia",
                "region" => "OC",
                "currency" => [
                "code" => "WST",
                    "name" => "Samoan tālā",
                    "symbol" => "T"
                ],
                "language" => [
                "code" => "sm",
                    "name" => "Samoan",
                ],
                "flag" => "https://restcountries.eu/data/wsm.svg"
            ],
            [
                "name" => "San Marino",
                "code" => "SM",
                "capital" => "City of San Marino",
                "region" => "EU",
                "currency" => [
                "code" => "EUR",
                    "name" => "Euro",
                    "symbol" => "€"
                ],
                "language" => [
                "code" => "it",
                    "name" => "Italian",
                ],
                "flag" => "https://restcountries.eu/data/smr.svg"
            ],
            [
                "name" => "Sao Tome and Principe",
                "code" => "ST",
                "capital" => "São Tomé",
                "region" => "AF",
                "currency" => [
                "code" => "STD",
                    "name" => "São Tomé and Príncipe dobra",
                    "symbol" => "Db"
                ],
                "language" => [
                "code" => "pt",
                    "name" => "Portuguese",
                ],
                "flag" => "https://restcountries.eu/data/stp.svg"
            ],
            [
                "name" => "Saudi Arabia",
                "code" => "SA",
                "capital" => "Riyadh",
                "region" => "AS",
                "currency" => [
                "code" => "SAR",
                    "name" => "Saudi riyal",
                    "symbol" => "ر.س"
                ],
                "language" => [
                "code" => "ar",
                    "name" => "Arabic",
                ],
                "flag" => "https://restcountries.eu/data/sau.svg"
            ],
            [
                "name" => "Senegal",
                "code" => "SN",
                "capital" => "Dakar",
                "region" => "AF",
                "currency" => [
                "code" => "XOF",
                    "name" => "West African CFA franc",
                    "symbol" => "Fr"
                ],
                "language" => [
                "code" => "fr",
                    "name" => "French",
                ],
                "flag" => "https://restcountries.eu/data/sen.svg"
            ],
            [
                "name" => "Serbia",
                "code" => "RS",
                "capital" => "Belgrade",
                "region" => "EU",
                "currency" => [
                "code" => "RSD",
                    "name" => "Serbian dinar",
                    "symbol" => "дин."
                ],
                "language" => [
                "code" => "sr",
                    "name" => "Serbian",
                ],
                "flag" => "https://restcountries.eu/data/srb.svg"
            ],
            [
                "name" => "Seychelles",
                "code" => "SC",
                "capital" => "Victoria",
                "region" => "AF",
                "currency" => [
                "code" => "SCR",
                    "name" => "Seychellois rupee",
                    "symbol" => "₨"
                ],
                "language" => [
                "code" => "fr",
                    "name" => "French",
                ],
                "flag" => "https://restcountries.eu/data/syc.svg"
            ],
            [
                "name" => "Sierra Leone",
                "code" => "SL",
                "capital" => "Freetown",
                "region" => "AF",
                "currency" => [
                "code" => "SLL",
                    "name" => "Sierra Leonean leone",
                    "symbol" => "Le"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/sle.svg"
            ],
            [
                "name" => "Singapore",
                "code" => "SG",
                "capital" => "Singapore",
                "region" => "AS",
                "currency" => [
                "code" => "SGD",
                    "name" => "Singapore dollar",
                    "symbol" => "$"
                 ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/sgp.svg"
            ],
            [
                "name" => "Sint Maarten (Dutch part)",
                "code" => "SX",
                "capital" => "Philipsburg",
                "region" => "Americas",
                "currency" => [
                "code" => "ANG",
                    "name" => "Netherlands Antillean guilder",
                    "symbol" => "ƒ"
                ],
                "language" => [
                "code" => "nl",
                    "name" => "Dutch",
                ],
                "flag" => "https://restcountries.eu/data/sxm.svg"
            ],
            [
                "name" => "Slovakia",
                "code" => "SK",
                "capital" => "Bratislava",
                "region" => "EU",
                "currency" => [
                "code" => "EUR",
                    "name" => "Euro",
                    "symbol" => "€"
                ],
                "language" => [
                "code" => "sk",
                    "name" => "Slovak",
                ],
                "flag" => "https://restcountries.eu/data/svk.svg"
            ],
            [
                "name" => "Slovenia",
                "code" => "SI",
                "capital" => "Ljubljana",
                "region" => "EU",
                "currency" => [
                "code" => "EUR",
                    "name" => "Euro",
                    "symbol" => "€"
                ],
                "language" => [
                "code" => "sl",
                    "name" => "Slovene",
                ],
                "flag" => "https://restcountries.eu/data/svn.svg"
            ],
            [
                "name" => "Solomon Islands",
                "code" => "SB",
                "capital" => "Honiara",
                "region" => "OC",
                "currency" => [
                "code" => "SBD",
                    "name" => "Solomon Islands dollar",
                    "symbol" => "$"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/slb.svg"
            ],
            [
                "name" => "Somalia",
                "code" => "SO",
                "capital" => "Mogadishu",
                "region" => "AF",
                "currency" => [
                "code" => "SOS",
                    "name" => "Somali shilling",
                    "symbol" => "Sh"
                ],
                "language" => [
                "code" => "ar",
                    "name" => "Arabic",
                ],
                "flag" => "https://restcountries.eu/data/som.svg"
            ],
            [
                "name" => "South Africa",
                "code" => "ZA",
                "capital" => "Pretoria",
                "region" => "AF",
                "currency" => [
                "code" => "ZAR",
                    "name" => "South African rand",
                    "symbol" => "R"
                ],
                "language" => [
                "code" => "en",
                    "iso639_2" => "eng",
                    "name" => "English",
                    "nativeName" => "English"
                ],
                "flag" => "https://restcountries.eu/data/zaf.svg"
            ],
            [
                "name" => "South Georgia and the South Sandwich Islands",
                "code" => "GS",
                "capital" => "King Edward Point",
                "region" => "NA",
                "currency" => [
                "code" => "GBP",
                    "name" => "British pound",
                    "symbol" => "£"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/sgs.svg"
            ],
            [
                "name" => "Korea (Republic of)",
                "code" => "KR",
                "capital" => "Seoul",
                "region" => "AS",
                "currency" => [
                "code" => "KRW",
                    "name" => "South Korean won",
                    "symbol" => "₩"
                ],
                "language" => [
                "code" => "ko",
                    "name" => "Korean",
                ],
                "flag" => "https://restcountries.eu/data/kor.svg"
            ],
            [
                "name" => "South Sudan",
                "code" => "SS",
                "capital" => "Juba",
                "region" => "AF",
                "currency" => [
                "code" => "SSP",
                    "name" => "South Sudanese pound",
                    "symbol" => "£"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/ssd.svg"
            ],
            [
                "name" => "Spain",
                "code" => "ES",
                "capital" => "Madrid",
                "region" => "EU",
                "currency" => [
                "code" => "EUR",
                    "name" => "Euro",
                    "symbol" => "€"
                ],
                "language" => [
                "code" => "es",
                    "name" => "Spanish",
                ],
                "flag" => "https://restcountries.eu/data/esp.svg"
            ],
            [
                "name" => "Sri Lanka",
                "code" => "LK",
                "capital" => "Colombo",
                "region" => "AS",
                "currency" => [
                "code" => "LKR",
                    "name" => "Sri Lankan rupee",
                    "symbol" => "Rs"
                ],
                "language" => [
                "code" => "si",
                    "iso639_2" => "sin",
                    "name" => "Sinhalese",
                    "nativeName" => "සිංහල"
                ],
                "flag" => "https://restcountries.eu/data/lka.svg"
            ],
            [
                "name" => "Sudan",
                "code" => "SD",
                "capital" => "Khartoum",
                "region" => "AF",
                "currency" => [
                "code" => "SDG",
                    "name" => "Sudanese pound",
                    "symbol" => "ج.س."
                ],
                "language" => [
                "code" => "ar",
                    "name" => "Arabic",
                ],
                "flag" => "https://restcountries.eu/data/sdn.svg"
            ],
            [
                "name" => "Suriname",
                "code" => "SR",
                "capital" => "Paramaribo",
                "region" => "SA",
                "currency" => [
                "code" => "SRD",
                    "name" => "Surinamese dollar",
                    "symbol" => "$"
                ],
                "language" => [
                "code" => "nl",
                    "name" => "Dutch",
                ],
                "flag" => "https://restcountries.eu/data/sur.svg"
            ],
            [
                "name" => "Svalbard and Jan Mayen",
                "code" => "SJ",
                "capital" => "Longyearbyen",
                "region" => "EU",
                "currency" => [
                "code" => "NOK",
                    "name" => "Norwegian krone",
                    "symbol" => "kr"
                ],
                "language" => [
                "code" => "no",
                    "name" => "Norwegian",
                ],
                "flag" => "https://restcountries.eu/data/sjm.svg"
            ],
            [
                "name" => "Swaziland",
                "code" => "SZ",
                "capital" => "Lobamba",
                "region" => "AF",
                "currency" => [
                "code" => "SZL",
                    "name" => "Swazi lilangeni",
                    "symbol" => "L"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/swz.svg"
            ],
            [
                "name" => "Sweden",
                "code" => "SE",
                "capital" => "Stockholm",
                "region" => "EU",
                "currency" => [
                "code" => "SEK",
                    "name" => "Swedish krona",
                    "symbol" => "kr"
                ],
                "language" => [
                "code" => "sv",
                    "name" => "Swedish",
                ],
                "flag" => "https://restcountries.eu/data/swe.svg"
            ],
            [
                "name" => "Switzerland",
                "code" => "CH",
                "capital" => "Bern",
                "region" => "EU",
                "currency" => [
                "code" => "CHF",
                    "name" => "Swiss franc",
                    "symbol" => "Fr"
                ],
                "language" => [
                "code" => "de",
                    "name" => "German",
                 ],
                "flag" => "https://restcountries.eu/data/che.svg"
            ],
            [
                "name" => "Syrian Arab Republic",
                "code" => "SY",
                "capital" => "Damascus",
                "region" => "AS",
                "currency" => [
                "code" => "SYP",
                    "name" => "Syrian pound",
                    "symbol" => "£"
                ],
                "language" => [
                "code" => "ar",
                    "name" => "Arabic",
                ],
                "flag" => "https://restcountries.eu/data/syr.svg"
            ],
            [
                "name" => "Taiwan",
                "code" => "TW",
                "capital" => "Taipei",
                "region" => "AS",
                "currency" => [
                "code" => "TWD",
                    "name" => "New Taiwan dollar",
                    "symbol" => "$"
                ],
                "language" => [
                "code" => "zh",
                    "name" => "Chinese",
                ],
                "flag" => "https://restcountries.eu/data/twn.svg"
            ],
            [
                "name" => "Tajikistan",
                "code" => "TJ",
                "capital" => "Dushanbe",
                "region" => "AS",
                "currency" => [
                "code" => "TJS",
                    "name" => "Tajikistani somoni",
                    "symbol" => "ЅМ"
                ],
                "language" => [
                "code" => "tg",
                    "name" => "Tajik",
                ],
                "flag" => "https://restcountries.eu/data/tjk.svg"
            ],
            [
                "name" => "Tanzania, United Republic of",
                "code" => "TZ",
                "capital" => "Dodoma",
                "region" => "AF",
                "currency" => [
                "code" => "TZS",
                    "name" => "Tanzanian shilling",
                    "symbol" => "Sh"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                 ],
                "flag" => "https://restcountries.eu/data/tza.svg"
            ],
            [
                "name" => "Thailand",
                "code" => "TH",
                "capital" => "Bangkok",
                "region" => "AS",
                "currency" => [
                "code" => "THB",
                    "name" => "Thai baht",
                    "symbol" => "฿"
                ],
                "language" => [
                "code" => "th",
                    "name" => "Thai",
                ],
                "flag" => "https://restcountries.eu/data/tha.svg"
            ],
            [
                "name" => "Timor-Leste",
                "code" => "TL",
                "capital" => "Dili",
                "region" => "AS",
                "currency" => [
                "code" => "USD",
                    "name" => "United States dollar",
                    "symbol" => "$"
                ],
                "language" => [
                "code" => "pt",
                    "name" => "Portuguese",
                ],
                "flag" => "https://restcountries.eu/data/tls.svg"
            ],
            [
                "name" => "Togo",
                "code" => "TG",
                "capital" => "Lomé",
                "region" => "AF",
                "currency" => [
                "code" => "XOF",
                    "name" => "West African CFA franc",
                    "symbol" => "Fr"
                ],
                "language" => [
                "code" => "fr",
                    "name" => "French",
                ],
                "flag" => "https://restcountries.eu/data/tgo.svg"
            ],
            [
                "name" => "Tokelau",
                "code" => "TK",
                "capital" => "Fakaofo",
                "region" => "OC",
                "currency" => [
                "code" => "NZD",
                    "name" => "New Zealand dollar",
                    "symbol" => "$"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/tkl.svg"
            ],
            [
                "name" => "Tonga",
                "code" => "TO",
                "capital" => "Nuku'alofa",
                "region" => "OC",
                "currency" => [
                "code" => "TOP",
                    "name" => "Tongan paʻanga",
                    "symbol" => "T$"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/ton.svg"
            ],
            [
                "name" => "Trinidad and Tobago",
                "code" => "TT",
                "capital" => "Port of Spain",
                "region" => "SA",
                "currency" => [
                "code" => "TTD",
                    "name" => "Trinidad and Tobago dollar",
                    "symbol" => "$"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/tto.svg"
            ],
            [
                "name" => "Tunisia",
                "code" => "TN",
                "capital" => "Tunis",
                "region" => "AF",
                "currency" => [
                "code" => "TND",
                    "name" => "Tunisian dinar",
                    "symbol" => "د.ت"
                ],
                "language" => [
                "code" => "ar",
                    "name" => "Arabic",
                ],
                "flag" => "https://restcountries.eu/data/tun.svg"
            ],
            [
                "name" => "Turkey",
                "code" => "TR",
                "capital" => "Ankara",
                "region" => "AS",
                "currency" => [
                "code" => "TRY",
                    "name" => "Turkish lira",
                    "symbol" => null
                ],
                "language" => [
                "code" => "tr",
                    "name" => "Turkish",
                ],
                "flag" => "https://restcountries.eu/data/tur.svg"
            ],
            [
                "name" => "Turkmenistan",
                "code" => "TM",
                "capital" => "Ashgabat",
                "region" => "AS",
                "currency" => [
                "code" => "TMT",
                    "name" => "Turkmenistan manat",
                    "symbol" => "m"
                ],
                "language" => [
                "code" => "tk",
                    "name" => "Turkmen",
                ],
                "flag" => "https://restcountries.eu/data/tkm.svg"
            ],
            [
                "name" => "Turks and Caicos Islands",
                "code" => "TC",
                "capital" => "Cockburn Town",
                "region" => "NA",
                "currency" => [
                "code" => "USD",
                    "name" => "United States dollar",
                    "symbol" => "$"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/tca.svg"
            ],
            [
                "name" => "Tuvalu",
                "code" => "TV",
                "capital" => "Funafuti",
                "region" => "OC",
                "currency" => [
                "code" => "AUD",
                    "name" => "Australian dollar",
                    "symbol" => "$"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/tuv.svg"
            ],
            [
                "name" => "Uganda",
                "code" => "UG",
                "capital" => "Kampala",
                "region" => "AF",
                "currency" => [
                "code" => "UGX",
                    "name" => "Ugandan shilling",
                    "symbol" => "Sh"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                 ],
                "flag" => "https://restcountries.eu/data/uga.svg"
            ],
            [
                "name" => "Ukraine",
                "code" => "UA",
                "capital" => "Kiev",
                "region" => "EU",
                "currency" => [
                "code" => "UAH",
                    "name" => "Ukrainian hryvnia",
                    "symbol" => "₴"
                ],
                "language" => [
                "code" => "uk",
                    "name" => "Ukrainian",
                ],
                "flag" => "https://restcountries.eu/data/ukr.svg"
            ],
            [
                "name" => "United Arab Emirates",
                "code" => "AE",
                "capital" => "Abu Dhabi",
                "region" => "AS",
                "currency" => [
                "code" => "AED",
                    "name" => "United Arab Emirates dirham",
                    "symbol" => "د.إ"
                ],
                "language" => [
                "code" => "ar",
                    "name" => "Arabic",
                ],
                "flag" => "https://restcountries.eu/data/are.svg"
            ],
            [
                "name" => "United Kingdom of Great Britain and Northern Ireland",
                "code" => "GB",
                "capital" => "London",
                "region" => "EU",
                "currency" => [
                "code" => "GBP",
                    "name" => "British pound",
                    "symbol" => "£"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/gbr.svg"
            ],
            [
                "name" => "United States of America",
                "code" => "US",
                "capital" => "Washington, D.C.",
                "region" => "NA",
                "currency" => [
                "code" => "USD",
                    "name" => "United States dollar",
                    "symbol" => "$"
                ],
                "language" => [
                "code" => "en",
                    "iso639_2" => "eng",
                    "name" => "English",
                    "nativeName" => "English"
                ],
                "flag" => "https://restcountries.eu/data/usa.svg"
            ],
            [
                "name" => "Uruguay",
                "code" => "UY",
                "capital" => "Montevideo",
                "region" => "SA",
                "currency" => [
                "code" => "UYU",
                    "name" => "Uruguayan peso",
                    "symbol" => "$"
                ],
                "language" => [
                "code" => "es",
                    "name" => "Spanish",
                ],
                "flag" => "https://restcountries.eu/data/ury.svg"
            ],
            [
                "name" => "Uzbekistan",
                "code" => "UZ",
                "capital" => "Tashkent",
                "region" => "AS",
                "currency" => [
                "code" => "UZS",
                    "name" => "Uzbekistani so'm",
                    "symbol" => null
                ],
                "language" => [
                "code" => "uz",
                    "name" => "Uzbek",
                ],
                "flag" => "https://restcountries.eu/data/uzb.svg"
            ],
            [
                "name" => "Vanuatu",
                "code" => "VU",
                "capital" => "Port Vila",
                "region" => "OC",
                "currency" => [
                "code" => "VUV",
                    "name" => "Vanuatu vatu",
                    "symbol" => "Vt"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/vut.svg"
            ],
            [
                "name" => "Venezuela (Bolivarian Republic of)",
                "code" => "VE",
                "capital" => "Caracas",
                "region" => "SA",
                "currency" => [
                "code" => "VEF",
                    "name" => "Venezuelan bolívar",
                    "symbol" => "Bs F"
                ],
                "language" => [
                "code" => "es",
                    "name" => "Spanish",
                ],
                "flag" => "https://restcountries.eu/data/ven.svg"
            ],
            [
                "name" => "Viet Nam",
                "code" => "VN",
                "capital" => "Hanoi",
                "region" => "AS",
                "currency" => [
                "code" => "VND",
                    "name" => "Vietnamese đồng",
                    "symbol" => "₫"
                ],
                "language" => [
                "code" => "vi",
                    "name" => "Vietnamese",
                ],
                "flag" => "https://restcountries.eu/data/vnm.svg"
            ],
            [
                "name" => "Wallis and Futuna",
                "code" => "WF",
                "capital" => "Mata-Utu",
                "region" => "OC",
                "currency" => [
                "code" => "XPF",
                    "name" => "CFP franc",
                    "symbol" => "Fr"
                ],
                "language" => [
                "code" => "fr",
                    "name" => "French",
                ],
                "flag" => "https://restcountries.eu/data/wlf.svg"
            ],
            [
                "name" => "Western Sahara",
                "code" => "EH",
                "capital" => "El Aaiún",
                "region" => "AF",
                "currency" => [
                "code" => "MAD",
                    "name" => "Moroccan dirham",
                    "symbol" => "د.م."
                ],
                "language" => [
                "code" => "es",
                    "name" => "Spanish",
                ],
                "flag" => "https://restcountries.eu/data/esh.svg"
            ],
            [
                "name" => "Yemen",
                "code" => "YE",
                "capital" => "Sana'a",
                "region" => "AS",
                "currency" => [
                "code" => "YER",
                    "name" => "Yemeni rial",
                    "symbol" => "﷼"
                ],
                "language" => [
                "code" => "ar",
                    "name" => "Arabic",
                ],
                "flag" => "https://restcountries.eu/data/yem.svg"
            ],
            [
                "name" => "Zambia",
                "code" => "ZM",
                "capital" => "Lusaka",
                "region" => "AF",
                "currency" => [
                "code" => "ZMW",
                    "name" => "Zambian kwacha",
                    "symbol" => "ZK"
                ],
                "language" => [
                "code" => "en",
                    "name" => "English",
                ],
                "flag" => "https://restcountries.eu/data/zmb.svg"
            ],
            [
                "name" => "Zimbabwe",
                "code" => "ZW",
                "capital" => "Harare",
                "region" => "AF",
                "currency" => [
                "code" => "BWP",
                    "name" => "Botswana pula",
                    "symbol" => "P"
                ],
                "language" => [
                "code" => "en",
                    "iso639_2" => "eng",
                    "name" => "English",
                    "nativeName" => "English"
                ],
                "flag" => "https://restcountries.eu/data/zwe.svg"
            ]
        ];

    public function getData(): array
    {
        return $this->countries;
    }
}
