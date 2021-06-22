// $(document).ready(function(){
//     // alert("hii..!");
//     $("#tabAjax").click(function() {
//         // alert("Ajax button clicked..!");
//         console.log("called..!!")
//     });
// });


// var pivot = new Flexmonster({
//     container: "pivot-container",
//     toolbar: true,
//     beforetoolbarcreated: customizeToolbar,
//     customizeAPIRequest: customizeAPIRequestFunction,

//     report: {
//         options: {
//             defaultDateType: "date string",
//             datePattern: "MMMM d, yyyy"
//         },
//         dataSource: {
//             type: "api",
//             url: "http://localhost:9500",
//             index: "order-details",
//         },
//         slice: {
//             rows: [
//                 { 
//                     uniqueName: "created_at",
//                     sort: "desc"
//                 }
//             ],
//             columns: [
//                 { 
//                     uniqueName: "total_price" 
//                 }
//             ],
//             measures: [
//                 {
//                     uniqueName: "total_price", 
//                     aggregation: "sum" 
//                 }
//             ],
//             reportFilters:[
//                 {
//                     uniqueName: "user_id_id",
//                     filter: {
//                         members: ["user_id_id.[12]"]
//                     }
//                 }
//             ]
//         }
    
//     },
//     licenseKey: "Z7ZP-XE2I72-682923-136R6E"
// });
// function customizeToolbar(toolbar) { 
//     // get all tabs 
//     var tabs = toolbar.getTabs(); 
//     toolbar.getTabs = function () { 
//         // delete the first tab 
//         delete tabs[0];
//         // delete tabs[11];
//         delete tabs[13];
//         return tabs; 
//     } 
// }

// function add() {
//     let condition = {
//         measure: "total_price",
//         isTotal: true,
//         formula: 'AND(#value > 1000, #value < 5000)',
//         format: {
//         backgroundColor: "#00FF00"
//         }
//     };
//     flexmonster.addCondition(condition);
//     flexmonster.refresh();
// }

// function remove() {
//     flexmonster.removeAllConditions();
//     flexmonster.refresh();
// }

// function showOutput(content) {
//     document.getElementById("output").innerText = content;
// } 

// function customizeAPIRequestFunction(req) {
//     // req = 
//     //     // {
//     //     //     "type": "fields",
//     //     //     "index": "order-details",
//     //     //     "fields": [
//     //     //         {
//     //     //             "uniqueName": "created_at",
//     //     //         },
//     //     //         {
//     //     //             "uniqueName": "user_id_id",
//     //     //             // "filters": {
//     //     //             //     "field": {
//     //     //             //         "uniqueName": "user_id_id"
//     //     //             //     },
//     //     //             //     "exclude": [
//     //     //             //         {
//     //     //             //             "member": 18
//     //     //             //         }
//     //     //             //     ]
//     //     //             // }
//     //     //         },
//     //     //         {
//     //     //             "uniqueName": "total_price",
//     //     //             "aggregation": "sum"
//     //     //         }
//     //     //     ]
//     //     // }
//     // {
//     //     "type": "select",
//     //     "index": "order-details",
//     //     "query": {
//     //         "aggs": {
//     //             "by": {
//     //                 "rows": [
//     //                     {
//     //                         "uniqueName": "created_at",
//     //                         "interval": "1d"
//     //                     }
//     //                 ],
//     //                 "cols": [
//     //                     {
//     //                         "uniqueName": "total_price"
//     //                     }
//     //                 ]
//     //             },
//     //             "values": [
//     //                 {
//     //                     "func": "sum",
//     //                     "field": {
//     //                         "uniqueName": "total_price"
//     //                     }
//     //                 }
//     //             ]
//     //         },
//     //         "filter":[
//     //             {
//     //                 "field": {
//     //                     "uniqueName": "user_id_id"
//     //                 },
//     //                 "exclude": [
//     //                     {
//     //                         "member": 12
//     //                     }
//     //                 ]
//     //             }
//     //         ],
//     //         "page": 0
//     //     }
//     // }
//     // };
//     showOutput(JSON.stringify(req, null, 2));
//     return req;
// }

// function customizeAPIRequestFunction1(req){
//     req =
//     {
//         "type": "members",
//         "index": "order-details",
//         "field":{
//             "uniqueName": "created_at"
//         },
//         "page": 0
//     }
//     return req;
// }