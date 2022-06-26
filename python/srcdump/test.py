import random
random.seed(42)

oneRandomEmpIdList = random.sample(range(20, 300), 99)
print("the list of fucking IDs:", oneRandomEmpIdList)
print("Length of fucking random list:",len(oneRandomEmpIdList))
for i in range (0, 100):
  oneRandomEmpId = oneRandomEmpIdList[i]
  print(oneRandomEmpId)
