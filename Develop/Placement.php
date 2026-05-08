<?php
// placement.php - The American College Campus Placement Opportunities

// Sample placement data (replace with DB query)
$placements = [
    ["company" => "TCS", "sector" => "IT", "eligibility" => "B.E/B.Tech", "deadline" => "2025-06-15"],
    ["company" => "Infosys", "sector" => "IT", "eligibility" => "Any Degree", "deadline" => "2025-06-20"],
    ["company" => "Wipro", "sector" => "IT", "eligibility" => "B.Sc CS", "deadline" => "2025-06-25"],
    ["company" => "HCL", "sector" => "IT", "eligibility" => "B.E/B.Tech", "deadline" => "2025-07-01"],
    ["company" => "Zoho", "sector" => "Software", "eligibility" => "B.E/B.Tech", "deadline" => "2025-07-05"],
    ["company" => "HDFC Bank", "sector" => "Finance", "eligibility" => "Any Degree", "deadline" => "2025-07-10"],
    ["company" => "Deloitte", "sector" => "Consulting", "eligibility" => "MBA", "deadline" => "2025-07-15"],
    ["company" => "Amazon", "sector" => "E-Commerce", "eligibility" => "B.E/B.Tech", "deadline" => "2025-07-20"],
];

// Filter logic
$search     = isset($_GET['search'])      ? trim($_GET['search'])      : '';
$sector     = isset($_GET['sector'])      ? $_GET['sector']            : '';
$eligibility= isset($_GET['eligibility']) ? $_GET['eligibility']       : '';
$deadline   = isset($_GET['deadline'])    ? $_GET['deadline']          : '';

$filtered = array_filter($placements, function($row) use ($search, $sector, $eligibility, $deadline) {
    if ($search      && stripos($row['company'],     $search)      === false) return false;
    if ($sector      && $row['sector']      !== $sector)                       return false;
    if ($eligibility && $row['eligibility'] !== $eligibility)                  return false;
    if ($deadline    && $row['deadline']    > $deadline)                        return false;
    return true;
});

// Unique values for dropdowns
$sectors      = array_unique(array_column($placements, 'sector'));
$eligibilities= array_unique(array_column($placements, 'eligibility'));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The American College – Placement</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Source+Sans+3:wght@300;400;600&display=swap');

        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --navy:   #00095C;
            --blue:   #0000FF;
            --light:  #F4F6FF;
            --white:  #ffffff;
            --gray:   #e8eaf6;
            --text:   #1a1a2e;
            --sidebar-w: 210px;
        }

        body {
            font-family: 'Source Sans 3', sans-serif;
            background: var(--light);
            color: var(--text);
            min-height: 100vh;
        }

        /* ── Header ── */
        #tit {
            background: var(--navy);
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 28px;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 12px rgba(0,0,92,.4);
        }
        #tit img {
            height: 52px;
            width: 52px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(255,255,255,.3);
            margin-left: 40px; /* Adjusted to move the logo further to the right */
        }
        #tit h1  { font-family: 'Playfair Display', serif; font-size: 1.55rem; flex-grow: 1; text-align: center; letter-spacing: .5px; }

        /* ── Layout ── */
        .layout {
            display: flex;
            min-height: calc(100vh - 80px);
        }

        /* ── Sidebar ── */
        .side {
            width: var(--sidebar-w);
            background: var(--blue);
            color: var(--white);
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 28px 16px;
            gap: 18px;
            flex-shrink: 0;
        }
        .side img { width: 90px; height: 90px; border-radius: 50%; object-fit: cover; border: 3px solid rgba(255,255,255,.4); }
        .side h2  { font-family: 'Playfair Display', serif; font-size: 1.1rem; }
        .side select {
            width: 100%;
            background: rgba(255,255,255,.15);
            border: 1px solid rgba(255,255,255,.4);
            color: var(--white);
            border-radius: 6px;
            padding: 6px 8px;
            font-size: .9rem;
        }
        .side select option { background: var(--blue); }

        /* ── Main ── */
        .main {
            flex: 1;
            padding: 32px 36px;
            overflow-x: auto;
        }
        .main h3 {
            font-family: 'Playfair Display', serif;
            font-size: 1.4rem;
            color: var(--navy);
            margin-bottom: 24px;
            border-left: 4px solid var(--blue);
            padding-left: 12px;
        }

        /* ── Filter Card ── */
        .filter-card {
            background: var(--white);
            border-radius: 12px;
            padding: 24px 28px;
            box-shadow: 0 2px 16px rgba(0,0,92,.08);
            margin-bottom: 28px;
        }
        .filter-card form {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            align-items: flex-end;
        }
        .filter-group { display: flex; flex-direction: column; gap: 6px; }
        .filter-group label { font-size: .8rem; font-weight: 600; color: var(--navy); text-transform: uppercase; letter-spacing: .5px; }

        input[type="text"],
        input[type="search"],
        input[type="date"],
        select {
            background: #f0f3ff;
            border: 2px solid var(--blue);
            border-radius: 7px;
            padding: 8px 12px;
            font-size: .95rem;
            font-family: inherit;
            transition: box-shadow .2s, transform .2s;
            outline: none;
            min-width: 160px;
        }
        input:hover, select:hover, input:focus, select:focus {
            box-shadow: 0 0 0 3px rgba(0,0,255,.18);
            transform: scale(1.025);
        }

        .btn {
            padding: 9px 22px;
            border: none;
            border-radius: 7px;
            font-family: inherit;
            font-size: .95rem;
            font-weight: 600;
            cursor: pointer;
            transition: background .2s, transform .15s;
        }
        .btn-primary { background: var(--blue); color: var(--white); }
        .btn-primary:hover { background: #2222dd; transform: translateY(-1px); }
        .btn-reset   { background: var(--white); color: var(--navy); border: 2px solid #bbc; }
        .btn-reset:hover { background: var(--gray); }

        /* ── Results Table ── */
        .table-wrap {
            background: var(--white);
            border-radius: 12px;
            box-shadow: 0 2px 16px rgba(0,0,92,.08);
            overflow: hidden;
        }
        table { width: 100%; border-collapse: collapse; }
        thead { background: var(--navy); color: var(--white); }
        thead th {
            padding: 14px 20px;
            text-align: left;
            font-family: 'Playfair Display', serif;
            font-size: 1rem;
            font-weight: 700;
            letter-spacing: .4px;
        }
        tbody tr { border-bottom: 1px solid #e8eaf6; transition: background .15s; }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: #f0f3ff; }
        tbody td { padding: 13px 20px; font-size: .95rem; }
        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: .8rem;
            font-weight: 600;
        }
        .badge-it       { background: #e3f2fd; color: #0d47a1; }
        .badge-finance  { background: #e8f5e9; color: #1b5e20; }
        .badge-software { background: #fff3e0; color: #e65100; }
        .badge-consulting{ background: #f3e5f5; color: #4a148c; }
        .badge-ecommerce{ background: #fce4ec; color: #880e4f; }
        .badge-default  { background: #f1f1f1; color: #555; }

        .no-results { text-align: center; padding: 40px; color: #888; font-size: 1rem; }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            .side { display: none; }
            .main { padding: 20px 16px; }
            .filter-card form { flex-direction: column; }
            input[type="text"], input[type="search"], input[type="date"], select { min-width: 100%; }
        }
    </style>
</head>
<body>

<!-- ── Header ── -->
<div id="tit">
    <img src="images2.jpeg" alt="College Logo">
    <h1>The American College</h1>
    <span style="width:52px;"></span><!-- spacer -->
</div>

<div class="layout">

    <!-- ── Sidebar ── -->
    <aside class="side">
        <img src="images1.png" alt="User">
        <h2>Placement</h2>
        <select onchange="location='?company='+this.value">
            <option value="">-- Company --</option>
            <?php foreach ($placements as $p): ?>
                <option value="<?= htmlspecialchars($p['company']) ?>"
                    <?= ($search === $p['company']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($p['company']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </aside>

    <!-- ── Main Content ── -->
    <main class="main">
        <h3>Campus Placement Opportunities</h3>

        <!-- Filter Form -->
        <div class="filter-card">
            <form method="GET" action="">
                <div class="filter-group">
                    <label for="search">Company</label>
                    <input type="search" id="search" name="search"
                           placeholder="Search company…"
                           value="<?= htmlspecialchars($search) ?>">
                </div>

                <div class="filter-group">
                    <label for="sector">Sector</label>
                    <select id="sector" name="sector">
                        <option value="">All Sectors</option>
                        <?php foreach ($sectors as $s): ?>
                            <option value="<?= htmlspecialchars($s) ?>"
                                <?= ($sector === $s) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($s) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="eligibility">Eligibility</label>
                    <select id="eligibility" name="eligibility">
                        <option value="">All Eligibility</option>
                        <?php foreach ($eligibilities as $e): ?>
                            <option value="<?= htmlspecialchars($e) ?>"
                                <?= ($eligibility === $e) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($e) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="deadline">Deadline Before</label>
                    <input type="date" id="deadline" name="deadline"
                           value="<?= htmlspecialchars($deadline) ?>">
                </div>

                <div style="display:flex;gap:10px;align-items:flex-end;">
                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                    <a href="placement.php"><button type="button" class="btn btn-reset">Reset</button></a>
                </div>
            </form>
        </div>

        <!-- Results Table -->
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Company Name</th>
                        <th>Sector</th>
                        <th>Eligibility</th>
                        <th>Deadline</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($filtered) > 0): ?>
                        <?php $i = 1; foreach ($filtered as $row): ?>
                            <?php
                                $sectorLower = strtolower($row['sector']);
                                $badgeClass = match($sectorLower) {
                                    'it'         => 'badge-it',
                                    'finance'    => 'badge-finance',
                                    'software'   => 'badge-software',
                                    'consulting' => 'badge-consulting',
                                    'e-commerce' => 'badge-ecommerce',
                                    default      => 'badge-default',
                                };
                            ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><strong><?= htmlspecialchars($row['company']) ?></strong></td>
                                <td><span class="badge <?= $badgeClass ?>"><?= htmlspecialchars($row['sector']) ?></span></td>
                                <td><?= htmlspecialchars($row['eligibility']) ?></td>
                                <td><?= htmlspecialchars(date('d M Y', strtotime($row['deadline']))) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="no-results">No placement opportunities match your filters.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <p style="margin-top:14px;font-size:.82rem;color:#888;">
            Showing <?= count($filtered) ?> of <?= count($placements) ?> opportunities.
        </p>
    </main>

</div><!-- /.layout -->

</body>
</html>