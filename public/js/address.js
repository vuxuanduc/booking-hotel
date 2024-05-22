const apiKey = '388deaa4-15c3-11ef-ab6e-ca4647523841' ;
const apiProvinces = "https://online-gateway.ghn.vn/shiip/public-api/master-data/province";
const apiDistricts = "https://online-gateway.ghn.vn/shiip/public-api/master-data/district";
const apiWard = "https://online-gateway.ghn.vn/shiip/public-api/master-data/ward?district_id" ;
const showProvinces = () => {
    fetch(apiProvinces , {
        method : 'GET' ,
        headers : {
            'Content-Type' : 'application/json' ,
            'Token' : apiKey
        }
    })
        .then((response) => response.json())
        .then((data) => {
            const listProvinces = data.data;

            listProvinces.forEach((province) => {
                const provinceSelect =
                    document.querySelector("#provinceSelect");
                const newOptionProvince = document.createElement("option");
                newOptionProvince.value = province.ProvinceID;
                newOptionProvince.textContent = province.ProvinceName;

                provinceSelect.appendChild(newOptionProvince);
            });
        });

        document.querySelector("#provinceSelect").addEventListener("change", () => {
            const province_id = document.querySelector("#provinceSelect").value;
            document.querySelector("#districtSelect").innerHTML = '<option value="">Chọn quận/huyện</option>';
    
            fetch(apiDistricts, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Token': apiKey
                },
                body: JSON.stringify({
                    province_id: parseInt(province_id) 
                })
            })
            .then((response) => response.json())
            .then((data) => {
                const listDistricts = data.data;
                const districtSelect = document.querySelector("#districtSelect");
    
                listDistricts.forEach((district) => {
                    const newOptionDistrict = document.createElement("option");
                    newOptionDistrict.value = district.DistrictID;
                    newOptionDistrict.textContent = district.DistrictName;
                    districtSelect.appendChild(newOptionDistrict);
                });
            })
            .catch((error) => {
                console.error('Error:', error);
            });
        });

    document.querySelector("#districtSelect").addEventListener("change", () => {
        const district_id = document.querySelector("#districtSelect").value;

        document.querySelector("#wardSelect").innerHTML =
            '<option value="">Chọn phường/xã</option>';

        fetch(
            apiWard , {
                method : "POST" ,
                headers : {
                    'Content-Type' : 'application/json' ,
                    'Token' : apiKey ,
                } ,
                body : JSON.stringify({
                    district_id : parseInt(district_id)
                })
            }
        )
            .then((response) => response.json())
            .then((data) => {
                const listWards = data.data;

                listWards.forEach((ward) => {
                    const wardsSelect =
                        document.querySelector("#wardSelect");
                    const newOptionWard = document.createElement("option");
                    newOptionWard.value = ward.WardID;
                    newOptionWard.textContent = ward.WardName;

                    wardsSelect.appendChild(newOptionWard);
                });
            });
    });
};

showProvinces();

