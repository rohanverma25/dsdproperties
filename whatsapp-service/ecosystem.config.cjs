// pm2 process file for the VPS. Start with:  pm2 start ecosystem.config.cjs
// .cjs because package.json sets "type": "module" and pm2 loads this with require().
module.exports = {
    apps: [{
        name: 'dsd-whatsapp',
        script: 'index.js',
        cwd: __dirname,
        // One instance only: two processes on the same auth/ folder would fight
        // over the WhatsApp session and get the device logged out.
        instances: 1,
        exec_mode: 'fork',
        autorestart: true,
        max_memory_restart: '400M',
        out_file: 'gateway.log',
        error_file: 'gateway.log',
        merge_logs: true,
        time: true,
    }],
};
