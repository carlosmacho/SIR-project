<?php
require "../../../utils/header.php";
require "../../db/connection.php";

?>

<?=template_header('Read')?>
<script src="/SIR-project/assets/js/netSalary.js"></script>
<!-- Content wrapper -->
<div class="content-wrapper">
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms/</span> Calculate Net Salary</h4>

    <!-- Basic Layout & Basic with Icons -->
    <div class="row">
    <!-- Basic Layout -->
    <div class="col-xxl">
        <div class="card mb-4">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Calculate Net Salary</h5>
        </div>
        <div class="card-body">
            
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="base_salary">Base Salary</label>
                <div class="col-sm-10">
                <div class="input-group input-group-merge">
                  <input type="number" required placeholder="1200€" class="form-control" id="base_salary" data-error="Please enter gross salary *"/>
                  <span class="input-group-text" id="basic-default-email2">€</span>
                </div>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="meal_allowance">Meal Allowance</label>
                <div class="col-sm-10">
                <select class="form-select form-select-lg mb-3" name="meal_allowance" id="meal_allowance">
                    <option value="no_allowance">No meal allowance</option>
                    <option value="card">Meal Card</option>
                    <option value="money">Money</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="meal_allowance_amount">Meal Allowance Amount</label>
                <div class="col-sm-10">
                <div class="input-group input-group-merge">
                    <input
                    type="number"
                    id="meal_allowance_amount"
                    placeholder="Enter Meal Allowance Amount"
                    value="0"
                    disabled
                    class="form-control"
                    aria-label="Meal Allowance Amount"
                    aria-describedby="basic-default-email2"
                    data-error="Please enter meal allowance amount *"
                    />
                    <span class="input-group-text" id="basic-default-email2">€</span>
                </div>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="meal_days">How many days did you work?</label>
                <div class="col-sm-10">
                <div class="input-group input-group-merge">
                  <input type="number" placeholder="Enter Meal Days" class="form-control" id="meal_days" value="0" disabled required/>
                  
                </div>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="password">The taxes you pay:</label>
                <div class="col-sm-10">
                <!-- Hoverable Table rows -->
              <div class="card">
                <h5 class="card-header">Taxes</h5>
                <div class="table-responsive text-nowrap">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>Gross Salary</th>
                        <th>IRS Tax</th>
                        <th>Social Security Tax</th>
                        <th>Meal Allowance Tax</th>
                        
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                      <tr>
                        <td><span id="gross_salary"></span></td>
                        <td><span id="descontos_irs"></span></td>
                        <td><span id="descontos_ss"></span></td>
                        <td><span id="meal_allowance_taxed"></span></td>
                      </tr>
                      <tr>
                        <td><strong>The taxes you pay are:</strong></td>
                        <td><span id="taxes"></span> <span id="status"></span></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td><strong>Your net salary is:</strong></td>
                        <td><span id="net_salary"></span></td> 
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td><strong>Received as meal allowance:</strong></td>
                        <td><span id="meal_allowance_value"></span></td> 
                        <td></td>
                        <td></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <!--/ Hoverable Table rows -->
                </div>
            </div>
            <div class="row justify-content-end">
                <div class="col-sm-10">
                <button class="btn btn-primary" id="calculate">Calculate</button>
                </div>
            </div>
        </div>
        </div>
    </div>
    
</div>

<?=template_footer()?>
