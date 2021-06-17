/** 
 * @license
 * Integration of amCharts with Flexmonster Pivot Table & Charts Component
 * Copyright (c) 2020 Flexmonster [https://flexmonster.com/]
 */
(function () {
    var FlexmonsterAmcharts = {};
    window["FlexmonsterAmcharts"] = FlexmonsterAmcharts;

    FlexmonsterAmcharts.getData = function (options, callbackHandler, updateHandler) {
        //define slice to select the data you would like to show (different from data that flexmonster instance is showing)
        //leave it undefined to get the data that flexmonster instance is showing
        var slice = options.slice;

        //please use prepareDataFunction if you need to prepare the data another way
        var _prepareDataFunction = options.prepareDataFunction;

        var _updateHandler;
        if (updateHandler != null) {
            _updateHandler = function (data) {
                if (_prepareDataFunction != undefined) {
                    updateHandler(_prepareDataFunction(data), data);
                } else {
                    updateHandler(prepareData(data), data);
                }
            };
        }

        this.instance.getData({
            slice: slice
        }, function (data) {
            if (_prepareDataFunction != undefined) {
                callbackHandler(_prepareDataFunction(data), data);
            } else {
                callbackHandler(prepareData(data), data);
            }
        }, _updateHandler);
    }

    FlexmonsterAmcharts.getNumberFormatPattern = function (format) {
        var basePattern = "###";
        if (format == null) return basePattern;
        var thousandsSeparator = (format["thousandsSeparator"] != undefined && format["thousandsSeparator"] != "");
        if (thousandsSeparator) {
            basePattern = "#," + basePattern;
        }
        var maxDecimalPlaces = (format["maxDecimalPlaces"] != undefined && format["maxDecimalPlaces"] > 0);
        var decimalPlaces = (format["decimalPlaces"] != undefined && format["decimalPlaces"] > 0);
        if (decimalPlaces) {
            basePattern = basePattern + ".";
            var numberOfDecimals = (maxDecimalPlaces && format["maxDecimalPlaces"] < format["decimalPlaces"]) ? format["maxDecimalPlaces"] : format["decimalPlaces"];
            for (var i = 0; i < numberOfDecimals; i++) {
                basePattern = basePattern + "0";
            }
        } else if (maxDecimalPlaces) {
            basePattern = basePattern + ".";
            for (var i = 0; i < format["maxDecimalPlaces"]; i++) {
                basePattern = basePattern + "#";
            }
        }
        var positivePattern = basePattern;
        var negativePattern = basePattern;
        var negativeNumberFormat = (format["negativeNumberFormat"] != undefined && format["negativeNumberFormat"] != "");
        var currencySymbol = (format["currencySymbol"] != undefined && format["currencySymbol"] != "");
        if (currencySymbol) {
            if (format["isPercent"] == true && format["currencySymbol"] != "%") {
                positivePattern = positivePattern + "%";
                negativePattern = negativePattern + "%";
            } else if (format["isPercent"] == true && format["currencySymbol"] == "%") {
                positivePattern = positivePattern + "\'" + format["currencySymbol"] + "\'";
                negativePattern = negativePattern + "\'" + format["currencySymbol"] + "\'";
            } else {
                if ((format["positiveCurrencyFormat"] == format["currencySymbol"] + "1") || (format["positiveCurrencyFormat"] == "$1")) {
                    positivePattern = "\'" + format["currencySymbol"] + "\'" + positivePattern;
                } else {
                    positivePattern = positivePattern + "\'" + format["currencySymbol"] + "\'";
                }

                if ((format["negativeCurrencyFormat"] == format["currencySymbol"] + "-1") || (format["negativeCurrencyFormat"] == "$-1")) {
                    negativePattern = "\'" + format["currencySymbol"] + "\'" + negativePattern;
                } else if ((format["negativeCurrencyFormat"] == "(" + format["currencySymbol"] + "1)") || (format["negativeCurrencyFormat"] == "($1)")) {
                    negativePattern = "\'(" + format["currencySymbol"] + "\'" + negativePattern + "s\')\'";
                } else if ((format["negativeCurrencyFormat"] == "(1" + format["currencySymbol"] + ")") || (format["negativeCurrencyFormat"] == "(1$)")) {
                    negativePattern = "\'(\'" + negativePattern + "s\'" + format["currencySymbol"] + ")\'";
                } else {
                    negativePattern = negativePattern + "\'" + format["currencySymbol"] + "\'";
                }
            }

        } else if (format["isPercent"] == true) {
            positivePattern = positivePattern + "%";
            negativePattern = negativePattern + "%";
        } else if (negativeNumberFormat) {
            if (format["negativeNumberFormat"] == "(1)") {
                negativePattern = "\'(\'" + negativePattern + "s\')\'";
            }
        }

        return positivePattern + "|" + negativePattern;
    }

    FlexmonsterAmcharts.getCategoryName = function (rawData) {
        var categoryName;
        if (rawData.meta && rawData.meta["rAmount"] > 0) {
            categoryName = rawData.meta["r0Name"];
        } else if (rawData.meta && rawData.meta["cAmount"] > 0) {
            categoryName = rawData.meta["c0Name"];
        }
        return categoryName;
    }

    FlexmonsterAmcharts.getMeasureNameByIndex = function (rawData, measureIndex) {
        return (rawData.meta && rawData.meta["vAmount"] > 0) ? rawData.meta["v" + measureIndex + "Name"] : undefined;
    }

    FlexmonsterAmcharts.getNumberOfMeasures = function (rawData) {
        return (rawData.meta) ? rawData.meta["vAmount"] : undefined;
    }

    function prepareData(data) {
        var output = {};
        output.options = prepareChartInfo(data);
        prepareSeries(output, data);
        return output;
    }

    function prepareChartInfo(data) {
        var output = {
            title: (data.meta && data.meta.caption) ? data.meta.caption : ""
        };
        return output;
    }

    function prepareSeries(output, data) {
        var records = [];
        var basedOnRows = false;
        var basedOnColumns = false;
        for (var i = 0; i < data.data.length; i++) {
            if (i == 0) {
                var headerRow = {};
                if (data.meta["rAmount"] > 0) {
                    headerRow["r0Name"] = data.meta["r0Name"];
                    basedOnRows = true;
                } else if (data.meta["cAmount"] > 0) {
                    headerRow["c0Name"] = data.meta["c0Name"];
                    basedOnColumns = true;
                }
                for (var j = 0; j < data.meta["vAmount"]; j++) {
                    headerRow["v" + j + "Name"] = data.meta["v" + j + "Name"];
                }
            }
            var record = data.data[i];
            var recordIsNotAFact = false;
            var _record = {};
            if (basedOnRows) {
                if (record["r0"] == undefined || record["r1"] != undefined || record["c0"] != undefined || record["v0"] == undefined) continue;
                _record[headerRow["r0Name"]] = record["r0"];
            }
            if (basedOnColumns) {
                if (record["c0"] == undefined || record["c1"] != undefined || record["r0"] != undefined || record["v0"] == undefined) continue;
                _record[headerRow["c0Name"]] = record["c0"];
            }
            for (var j = 0; j < data.meta["vAmount"]; j++) {
                if (record["v" + j] == undefined) {
                    recordIsNotAFact = true;
                    continue;
                }
                _record[headerRow["v" + j + "Name"]] = !isNaN(record["v" + j]) ? record["v" + j] : 0;
            }
            if (recordIsNotAFact) continue;
            records.push(_record);
        }
        output.data = records;
    }

})();