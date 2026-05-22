const MONGIKE_API_KEY = process.env.MONGIKE_API_KEY || 'mk_c3cc4ef6fe9618f93e91f16aae28537e388966f712244d9e';

module.exports = async (req, res) => {
  if (req.method !== 'POST') {
    res.status(405).json({ status: 'error', message: 'Method not allowed' });
    return;
  }

  const incomingKey = req.headers['x-api-key'];
  if (incomingKey !== MONGIKE_API_KEY) {
    res.status(401).json({ status: 'error', message: 'Invalid webhook signature' });
    return;
  }

  console.log('Mongike webhook received:', req.body);
  res.status(200).json({ status: 'success', message: 'Webhook received' });
};
