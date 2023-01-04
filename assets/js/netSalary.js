window.addEventListener("load", () => {
  let taxes = {
    710: 0,
    720: 1.8,
    740: 4.5,
    760: 5,
    822: 7.9,
    931: 10.1,
    1015: 11.3,
    1075: 12.1,
    1154: 13.1,
    1237: 14.1,
    1333: 15.2,
    1437: 16.2,
    1577: 17.2,
    1727: 18.6,
    1887: 19.9,
    1995: 20.9,
    2109: 21.9,
    2238: 22.8,
    2389: 23.8,
    2558: 24.8,
    2792: 25.8,
    3132: 27,
    3566: 28.6,
    4156: 29.7,
    4692: 31.4,
    5241: 32.3,
    5933: 33.3,
    6788: 35.3,
    8011: 36.3,
    9647: 38.2,
    11384: 39.2,
    19024: 40.2,
    20403: 41.2,
    22954: 41.9,
    25504: 42.9,
    25505: 43.8,
  };
  let typeMealAllowance = document.getElementById("meal_allowance");
  let mealAllowance = document.getElementById("meal_allowance_amount");

  typeMealAllowance.addEventListener("change", () => {
    if (typeMealAllowance.value === "no_allowance") {
      mealAllowance.value = 0;
      mealAllowance.disabled = true;
    } else {
      mealAllowance.disabled = false;
    }
  });

  function getTaxRate(grossSalary, taxTable) {
    for (let salary in taxTable) {
      if (salary >= grossSalary) {
        return taxTable[salary];
      }
    }
    return 43.8;
  }
  function calculateMealAllowance(
    netSalary,
    grossSalary,
    typeMealAllowance,
    mealAllowance
  ) {
    if (typeMealAllowance === "no_allowance") {
      return { netSalary: netSalary, grossSalary: grossSalary };
    } else if (typeMealAllowance === "card") {
      if (mealAllowance >= 7.33) {
        grossSalary = grossSalary + (mealAllowance - 7.33) * 22;
        netSalary = netSalary + 7.33 * 22;
      } else {
        netSalary = netSalary + mealAllowance * 22;
      }
    } else if (typeMealAllowance === "money") {
      if (mealAllowance >= 4.57) {
        grossSalary = grossSalary + (mealAllowance - 4.57) * 22;
        netSalary = netSalary + 4.57 * 22;
      } else {
        netSalary = netSalary + mealAllowance * 22;
      }
    }
    return { netSalary: netSalary, grossSalary: grossSalary };
  }
  function calculateNetSalary() {
    let netSalaryTemp = 0;
    let grossSalary = +document.getElementById("base_salary").value;
    let typeMealAllowance = document.getElementById("meal_allowance").value;
    let mealAllowance = +document.getElementById("meal_allowance_amount").value;
    const result = calculateMealAllowance(
      netSalaryTemp,
      grossSalary,
      typeMealAllowance,
      mealAllowance
    );
    netSalaryTemp = result.netSalary;
    grossSalary = result.grossSalary;
    const taxOwed = getTaxRate(grossSalary, taxes);

    const descontos_ss = grossSalary * (11 / 100);
    const descontos_irs = grossSalary * (taxOwed / 100);

    const netSalary =
      grossSalary - descontos_irs - descontos_ss + netSalaryTemp;
    document.getElementById("net_salary").textContent = netSalary.toFixed(2) + "€";
    document.getElementById("descontos_irs").textContent =
      descontos_irs.toFixed(2) + "€";
    document.getElementById("descontos_ss").textContent =
      descontos_ss.toFixed(2) + "€";
    document.getElementById("gross_salary").textContent =
      grossSalary.toFixed(2) + "€";
    document.getElementById("taxes").textContent = taxOwed.toFixed(2) + "%";

    // Change status column
    let status = "";
    if(taxOwed <= 14.5) {
      status = '<span class="badge bg-label-success me-1">Low</span>';
    } else if (taxOwed > 14.5 && taxOwed <= 30) {
      status = '<span class="badge bg-label-warning me-1">Average</span>';
    } else {
      status = '<span class="badge bg-label-danger me-1">Very High</span>';
    }
    document.getElementById('status').innerHTML = status;
  }

  const calculateButton = document.getElementById("calculate");
  calculateButton.addEventListener("click", calculateNetSalary);
  
});
