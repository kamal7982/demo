
SELECT clients_data.qr_id
FROM clients_data
INNER JOIN clients_equipments ON clients_data.qr_id = clients_equipments.qr_id;

SELECT clients_data.*
FROM clients_data
LEFT JOIN clients_equipments ON clients_data.qr_id = clients_equipments.qr_id
WHERE clients_equipments.qr_id IS NULL;


SELECT clients_data.id, clients_data.qr_id, clients_data.ContactName,clients_data.Email,clients_data.Reminder_days,clients_data.Lang,inspection.created_date, clients_data.created_at
FROM clients_data
LEFT JOIN clients_equipments ON clients_data.qr_id = clients_equipments.qr_id
LEFT JOIN inspection ON clients_data.qr_id = inspection.qr_id
WHERE clients_equipments.qr_id IS NULL GROUP BY clients_data.id, clients_data.qr_id, clients_data.Reminder_days, inspection.created_date,clients_data.Email;


SELECT clients_data.qr_id, clients_data.ContactName, clients_data.Email, clients_data.Reminder_days, clients_data.Lang, MAX(inspection.created_date) AS Last_Inspection_Date
FROM clients_data
LEFT JOIN clients_equipments ON clients_data.qr_id = clients_equipments.qr_id
LEFT JOIN inspection ON clients_data.qr_id = inspection.qr_id
WHERE clients_equipments.qr_id IS NULL
GROUP BY clients_data.qr_id
ORDER BY Last_Inspection_Date DESC;