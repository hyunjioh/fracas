<?
include_once 'pub.config.php';
include_once 'common.php';
?>
</head>
<body>
<div id="wrap">
    <?include_once PATH.'/inc/head.php';?>
    <?include_once PATH.'/inc/side_nav.php';?>
    <div id="submit_1">
        <div class="inner">
            <table>
                <tr>
                    <tr class="title">
                        <td>Work order No.</td>
                        <td>Date</td>
                        <td>Tram No</td>
                        <td>Sub-system</td>
                        <td>Equipment or Component</td>
                        <td>Location</td>
                        <td>Failure Description</td>
                        <td>Action Taken</td>
                        <td colspan="2">Did tram drive off route due to the failure?</td>
                        <td>Repairable?</td>
                    </tr>
                    <tr class="content">
                        <td>
                            <textarea placeholder="TWRW20201101"></textarea>
                        </td>
                        <td>2020-11-01</td>
                        <td>
                            <textarea placeholder="차량번호"></textarea>
                        </td>
                        <td>
                            <select>
                                <optgroup label="Carbody">
                                    <option>Body Frame</option>
                                    <option>Couplers</option>
                                </optgroup>
                                <option>Carbody</option>
                                <option>Brake System</option>
                                <option>Mechanical Equipment</option>
                                <option>Door System</option>
                                <option>HVAC Syetem</option>
                                <option>Bogie</option>
                                <option>Communication System</option>
                                <option>Radio Point Control System</option>
                                <option>Passenger Counting System</option>
                                <option>Fare Collection System</option>
                                <option>TCMS</option>
                                <option>Event Recorder</option>
                                <option>Propulsion System</option>
                                <option>Other Devices</option>
                            </select>
                        </td>
                        <td>
                            <select>
                                <option>Body Frame</option>
                                <option>Couplers</option>
                                <option>Gangways</option>
                                <option>Articulation</option>
                                <option>Windshield Wiper</option>
                                <option>Driver Seat</option>
                                <option>Master Controller</option>
                                <option>Lightings</option>
                                <option>Other Devices</option>
                                <option>Electronic Brake Control Unit(EBCU)</option>
                                <option>Electro Hydrauilic Control Unit(EHCU)</option>
                                <option>Magnetic Track Brake(MTB)</option>
                                <option>Hydraulic Brake Caliper </option>
                                <option>Other Devices</option>
                                <option>Mechanical Parts</option>
                                <option>Passenger Compartment Door</option>
                                <option>HVAC</option>
                                <option>Smoke Detector</option>
                                <option>Bogie Frame</option>
                                <option>Driving Gear</option>
                                <option>Wheelset</option>
                                <option>Primary Spring</option>
                                <option>Secondary Spring</option>
                                <option>Damper</option>
                                <option>Wheel Flange Lubricator</option>
                                <option>Other Devices</option>
                                <option>PA</option>
                                <option>PIS</option>
                                <option>CCTV</option>
                                <option>PCS</option>
                                <option>ABS</option>
                                <option>Other Devices</option>
                                <option>Traction Motor</option>
                                <option>Auxiliary Power Supply</option>
                                <option>Pantograph</option>
                                <option>Battery</option>
                                <option>Other Devices</option>
                            </select>
                        </td>
                        <td>
                            <select>
                                <option>Operation Line</option>
                                <option>Depot</option>
                                <option>ETC</option>
                            </select>
                        </td>
                        <td>
                            <textarea placeholder="Text"></textarea>
                        </td>
                        <td>
                            <textarea placeholder="Text"></textarea>
                        </td>
                        <td colspan="2">
                            <select>
                                <option>Y</option>
                                <option>N</option>
                            </select>
                        </td>
                        <td>
                            <select>
                                <option>Y</option>
                                <option>N</option>
                            </select>
                        </td>
                    </tr>        
                </tr>
                <tr >
                    <tr class="title">
                        <td>Repair Type</td>
                        <td>The Number of Maintenance Personnel</td>
                        <td>Restore Time(min)</td>
                        <td>Response Time(min)*Only for IT system</td>
                        <td>Failure rectification time (hours)*Only for IT system</td>
                        <td>Supplier</td>
                        <td>Responsibility</td>
                        <td>STATUS</td>
                        <td>Completion Date</td>
                        <td>Final Decision- Is it calculated as a failure?</td>
                        <td>Remark</td>
                    </tr> 
                    <tr class="content">
                        <td>
                            <select>
                                <option>HW</option>
                                <option>SW</option>
                                <option>AD</option>
                                <option>WK</option>
                                <option>OP</option>
                                <option>NFF</option>
                                <option>ETC</option>
                                <option>TBD</option>
                            </select>
                        </td>
                        <td>
                            <textarea placeholder="숫자입력"></textarea>
                        </td>
                        <td>
                            <textarea placeholder="숫자입력"></textarea>
                        </td>
                        <td>
                            <textarea placeholder="숫자입력"></textarea>
                        </td>
                        <td>
                            <textarea placeholder="숫자입력"></textarea>
                        </td>
                        <td>
                            <textarea placeholder="Text"></textarea>
                        </td>
                        <td>
                            <select>
                                <option>HRC</option>
                                <option>TW</option>
                                <option>TBD</option>
                            </select>
                        </td>
                        <td>
                            <select>
                                <option>Open</option>
                                <option>Closed</option>
                            </select>
                        </td>
                        <td>2020-11-04</td>
                        <td>
                            <select>
                                <option>Y</option>
                                <option>N</option>
                            </select>
                        </td>
                        <td>
                            <textarea placeholder="Text"></textarea>
                        </td>
                    </tr>
                </tr>
            </table>
        </div>
    </div>
    <?include_once PATH.'/inc/footer.php';?>
</div> 
</body>
</html>